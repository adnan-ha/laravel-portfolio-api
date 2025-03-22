<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'field_of_study',
        'institution',
        'description',
        'start_date',
        'end_date',
        'user_id',
    ];
}
