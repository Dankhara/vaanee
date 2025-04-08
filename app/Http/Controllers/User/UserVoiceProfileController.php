<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserVoiceProfileScript;
use App\Models\VoiceCloneScriptLanguage;
use App\Models\VoiceCloneScriptLanguageScript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class UserVoiceProfileController extends Controller
{
    public function record_user_voice()
    {
        $languages = DB::table('voices')
            ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
            ->join('voiceover_languages', 'voices.language_code', '=', 'voiceover_languages.language_code')
            ->where('vendors.enabled', '1')
            ->where('voices.status', 'active')
            ->where('voices.voice_type', 'neural')
            ->select('voiceover_languages.id', 'voiceover_languages.language', 'voices.language_code', 'voiceover_languages.language_flag')
            ->distinct()
            ->orderBy('voiceover_languages.language', 'asc')
            ->get();
        $voiceCloneScriptLanguage = VoiceCloneScriptLanguage::query()->pluck('language_code')->toArray();
        return view('user.voice-profile.record-improve-user-voice-score', compact(
            'languages',
            'voiceCloneScriptLanguage'
        ));
    }

    public function get_language_code_script(Request $request)
    {
        if ($request->ajax()) {
            $voice_clone_script_language_id = VoiceCloneScriptLanguage::where('language_code', $request->language_code)->value('id');
            $voice_clone_script_language_script_ids = UserVoiceProfileScript::where('user_id', auth()->id())
                ->where('language_code', $request->language_code)
                ->pluck('voice_clone_script_language_script_id')
                ->toArray();
            $voiceCloneScripts = VoiceCloneScriptLanguageScript::where('voice_clone_script_language_id', $voice_clone_script_language_id)
                ->whereNotIn('id', $voice_clone_script_language_script_ids)
                ->pluck('voice_script', 'id')
                ->toArray();
            if (count($voiceCloneScripts) > 0) {
                $id = array_rand($voiceCloneScripts);
                $script = $voiceCloneScripts[$id];
                $stage = count($voice_clone_script_language_script_ids) + 1;
            } else {
                $id = null;
                $script = null;
                $stage = count($voice_clone_script_language_script_ids) . ' (Completed)';
            }

            $data = [
                'script' => $script,
                'voice_clone_script_language_script_id' => $id,
                'stage' => 'Stage ' . $stage
            ];
            return $data;
        }
    }

    public function upload_user_voice_profile_script(Request $request)
    {
        $file = null;
        if ($request->hasFile('video') && $request->file('video')->isValid()) {
            $file = $request->file('video');
        } elseif ($request->hasFile('audiofile') && $request->file('audiofile')->isValid() && $request->audiolength != 'undefined') {
            $file = $request->file('audiofile');
        }
        try {
            // send the data to server for processing
            $apiUrl = config('app.vaanee_api_endpoint') . 'vaanee/api/userprofile-audio/';
            $client = new Client();
            $yourAccessToken = getAccessToken();
            $response = $client->post($apiUrl, [
                'multipart' => [
                    [
                        'name'     => 'audio_file',    // Field name for the file
                        'contents' => fopen($file->getPathname(), 'r'),  // Open the file for reading
                        'filename' => $file->getClientOriginalName(),
                    ],
                    // other fields
                    [
                        'name'     => 'language',
                        'contents' => $request->language,
                    ],
                    [
                        'name'     => 'accent',
                        'contents' => $request->accent,
                    ],
                    [
                        'name'     => 'style',
                        'contents' => $request->style,
                    ],
                    [
                        'name'     => 'gender',
                        'contents' => $request->gender,
                    ],
                    [
                        'name'     => 'age_group',
                        'contents' => $request->age_group,
                    ],
                    [
                        'name'     => 'emotions',
                        'contents' => $request->emotions,
                    ],
                    [
                        'name'     => 'pitch',
                        'contents' => $request->pitch,
                    ],
                    [
                        'name'     => 'stage',
                        'contents' => str_replace(' ', '', $request->language_stage),
                    ],
                    // Add more fields if necessary
                ],
                // You can customize the request further, such as adding headers
                'headers' => [
                    'Authorization' => 'Bearer ' . $yourAccessToken,
                ],
            ]);
            //store date in local database
            UserVoiceProfileScript::create([
                'user_id' => auth()->id(),
                'language_code' => $request->language,
                'accent' => $request->accent,
                'style' => $request->style,
                'gender' => $request->gender,
                'age_group' => $request->age_group,
                'emotions' => $request->emotions,
                'pitch' => $request->pitch,
                'voice_clone_script_language_script_id' => $request->voice_clone_script_language_script_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $responseBody = $response->getBody()->getContents();
            return response()->json([
                'message' => 'Voice profile saved successfully', 'response' => json_decode($responseBody)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
