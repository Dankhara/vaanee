<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voice extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'voice',
        'sample_url',
        'voice_type',
        'voice_id',
        'vendor_id',
        'vendor',
        'vendor_img',
        'gender',
        'language_code',
        'user_id',
    ];

}
