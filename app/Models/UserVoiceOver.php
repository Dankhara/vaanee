<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoiceOver extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'file_url',
        'file_name',
        'file_size',
        'format',
        'storage',
        'length',
        'words',
        'plan_type',
        'audio_type',
        'status',
        'mode',
    ];


    /**
     * Result belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
