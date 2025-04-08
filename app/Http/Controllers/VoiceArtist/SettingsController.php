<?php

namespace App\Http\Controllers\VoiceArtist;

use App\Http\Controllers\Controller;
use App\Models\VoiceArtistAudioSetting;
use App\Models\VoiceCloneScriptLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function show_audio_settings_page()
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
        $audio_settings = VoiceArtistAudioSetting::where('user_id', auth()->id())
            ->get();
        $default_audio_settings = $audio_settings->where('audio_setting_type', 'default_language')
            ->pluck('audio_setting_language_code')
            ->toArray();
        $preferred_audio_settings = $audio_settings->where('audio_setting_type', 'preferred_language')
            ->pluck('audio_setting_language_code')
            ->toArray();
        // ------------------------------------------------------
        $voiceCloneScriptLanguage = VoiceCloneScriptLanguage::query()->pluck('language_code')->toArray();
        return view('voice-artist.settings.settings', compact(
            'languages',
            'default_audio_settings',
            'preferred_audio_settings',
            'voiceCloneScriptLanguage'
        ));
    }

    public function save_audio_settings(Request $request)
    {
        $request->validate([
            'default_languages' => 'present',
            'default_languages.*' => 'required',
            'preferred_language' => 'present',
            'preferred_language.*' => 'required',
        ]);
        try {
            VoiceArtistAudioSetting::where('user_id', auth()->id())->delete();
            foreach ($request->default_languages as $language_code) {
                VoiceArtistAudioSetting::create([
                    'user_id' => auth()->id(),
                    'audio_setting_type' => 'default_language',
                    'audio_setting_language_code' => $language_code,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            foreach ($request->preferred_language as $language_code) {
                VoiceArtistAudioSetting::create([
                    'user_id' => auth()->id(),
                    'audio_setting_type' => 'preferred_language',
                    'audio_setting_language_code' => $language_code,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return back()
                ->with('success', __('Settings saved successfully.'));
        } catch (\Exception $ex) {
            return back()
                ->with('error', __('Something went wrong. TRy again after sometime.'));
        }
    }

    public function voice_profile_settings()
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
        $voiceCloneScriptLanguage = VoiceCloneScriptLanguage::query()
            ->pluck('language_code')
            ->toArray();
        return view('voice-artist.settings.voice-profile-settings', compact(
            'voiceCloneScriptLanguage',
            'languages'
        ));
    }

    public function wallet_settings()
    {
        return view('voice-artist.settings.wallet-settings');
    }
}
