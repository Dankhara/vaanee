<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_position',
        'job_description',
        'image',
        'status',
        'created_at',
        'updated_at',
        'job_category',
        'start_date',
        'end_date',
        'salary',
        'salary_type',
        'no_of_positions',
        'education',
        'job_type',
        'duration',
    ];
}
