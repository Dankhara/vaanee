<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoiceProfileScript extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'language_code',
        'accent',
        'style',
        'gender',
        'age_group',
        'emotions',
        'pitch',
        'voice_clone_script_language_script_id',
        'created_at',
        'updated_at'
    ];
}
