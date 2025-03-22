<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'job_title',
        'company',
        'start_date',
        'end_date',
        'description',
        'user_id',
    ];
}
