<?php

namespace App\Http\Controllers\VoiceArtist;

use App\Http\Controllers\Controller;
use App\Models\VoiceArtistAudioSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudioController extends Controller
{
    public function show_studio_view()
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
        return view('voice-artist.studio.voice-studio', compact(
            'languages',
            'default_audio_settings',
            'preferred_audio_settings'
        ));
    }
}
