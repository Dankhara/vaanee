<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoiceArtistAudioSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'audio_setting_type',
        'audio_setting_language_code',
        'created_at',
        'updated_at'
    ];
}
