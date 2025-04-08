<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoiceCloneScriptLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_code', 'created_at', 'updated_at'
    ];

    public function voice_clone_script_language_scripts()
    {
        return $this->hasMany(VoiceCloneScriptLanguageScript::class, 'voice_clone_script_language_id');
    }
}
