<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranscribeResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',  
        'text', 
        'file_url', 
        'file_name', 
        'file_size', 
        'language', 
        'language_flag', 
        'format', 
        'storage',
        'task_id', 
        'gcp_task',
        'vendor_img', 
        'vendor', 
        'length', 
        'words',
        'plan_type', 
        'audio_type',
        'status',
        'mode',
        'raw',
        'project',
        'speaker_identity',
    ];


    /**
     * Result belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
