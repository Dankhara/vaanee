<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoiceCloneScriptLanguageScript extends Model
{
    use HasFactory;

    protected $fillable = [
        'voice_clone_script_language_id', 'voice_script', 'created_at', 'updated_at'
    ];
}
