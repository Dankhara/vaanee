<?php

namespace App\Http\Controllers\Admin\VoiceClone;

use App\Http\Controllers\Controller;
use App\Models\VoiceCloneScriptLanguage;
use App\Models\VoiceCloneScriptLanguageScript;
use App\Models\VoiceoverLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\URL;

class VoiceCloneScriptController extends Controller
{
    public function voice_clone_script(Request $request)
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
        if ($request->ajax()) {
            $voiceCloneScriptLanguage = VoiceCloneScriptLanguage::query()
                ->withCount('voice_clone_script_language_scripts')->get();
            return Datatables::of($voiceCloneScriptLanguage)
                ->addIndexColumn()
                ->addColumn('language-code', function ($row) use ($languages) {
                    $language_code = '';
                    $language_found = $languages->where('language_code', $row['language_code'])->first();
                    if ($language_found) {
                        $language_code = '<img src="' . URL::asset($language_found->language_flag) . '" style="width:22px;" > '  . $language_found->language;
                    }
                    return $language_code;
                })
                ->addColumn('created-on', function ($row) {
                    $created_on = '<span class="font-weight-bold">' . date_format($row["created_at"], 'd M Y') . '</span>';
                    return $created_on;
                })
                ->addColumn('no-of-scripts', function ($row) {
                    $no_of_scripts = $row['voice_clone_script_language_scripts_count'];
                    return $no_of_scripts;
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<div>
                                        <a href="' . route("voice.clone.edit.voice.clone.script", $row["id"]) . '"><i class="fa-sharp fa-solid fa-edit table-action-buttons request-action-button" title="View/Edit"></i></a>
                                        <a class="deleteScriptButton" id="' . $row["id"] . '" href="#"><i class="fa-solid fa-trash table-action-buttons delete-action-button" title="Delete"></i></a>
                                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['actions', 'created-on', 'language-code'])
                ->make(true);
        }
        return view('admin.voice-clone.voice-clone-scripts', compact(
            'languages'
        ));
    }

    public function create_voice_clone_script()
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
        $voiceCloneScriptLanguageCodes = VoiceCloneScriptLanguage::query()
            ->pluck('language_code')->toArray();
        return view('admin.voice-clone.create-voice-clone-script', compact(
            'languages',
            'voiceCloneScriptLanguageCodes'
        ));
    }

    public function store_voice_clone_script(Request $request)
    {
        try {
            DB::beginTransaction();
            $voiceCloneScriptLanguage = VoiceCloneScriptLanguage::create([
                'language_code' => $request->language_code,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            foreach ($request->voice_script as $key => $voice_script) {
                VoiceCloneScriptLanguageScript::create([
                    'voice_clone_script_language_id' => $voiceCloneScriptLanguage->id,
                    'voice_script' => $voice_script,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::commit();
            return redirect()->route('voice.clone.voice.clone.script')
                ->with('success', __('Voice scripts saved successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', __('Something went wrong. TRy again after sometime.'));
        }
    }

    public function edit_voice_clone_script($id)
    {
        $VoiceCloneScriptLanguage = VoiceCloneScriptLanguage::where('id', $id)
            ->with('voice_clone_script_language_scripts')
            ->firstOrFail();
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
        return view('admin.voice-clone.edit-voice-clone-script', compact(
            'languages',
            'VoiceCloneScriptLanguage'
        ));
    }

    public function update_voice_clone_script(Request $request, $voiceCloneScriptLanguageId)
    {
        try {
            DB::beginTransaction();
            foreach ($request->voice_script as $key => $voice_script) {
                if (isset($request->voice_clone_script_language_script_id[$key]) && $request->voice_clone_script_language_script_id[$key]) {
                    VoiceCloneScriptLanguageScript::where('id', $request->voice_clone_script_language_script_id[$key])
                        ->update([
                            'voice_script' => $voice_script,
                            'updated_at' => now(),
                        ]);
                } else {
                    VoiceCloneScriptLanguageScript::create([
                        'voice_clone_script_language_id' => $voiceCloneScriptLanguageId,
                        'voice_script' => $voice_script,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            DB::commit();
            return back()
                ->with('success', __('Voice scripts updated successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', __('Something went wrong. TRy again after sometime.'));
        }
    }

    public function delete_language_and_scripts(Request $request)
    {
        if ($request->ajax()) {
            $VoiceCloneScriptLanguage = VoiceCloneScriptLanguage::find(request('id'));
            if ($VoiceCloneScriptLanguage) {
                VoiceCloneScriptLanguageScript::where('voice_clone_script_language_id', $VoiceCloneScriptLanguage->id)->delete();
                $VoiceCloneScriptLanguage->delete();
                return response()->json('success');
            } else {
                return response()->json('error');
            }
        }
    }

    public function delete_language_script(Request $request)
    {
        if ($request->ajax()) {
            $VoiceCloneScriptLanguageScript = VoiceCloneScriptLanguageScript::find(request('id'));
            if ($VoiceCloneScriptLanguageScript) {
                $VoiceCloneScriptLanguageScript->delete();
                return response()->json('success');
            } else {
                return response()->json('error');
            }
        }
    }
}
