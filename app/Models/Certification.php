<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'name',
        'organization',
        'issued_date',
        'certification_url',
        'user_id',
    ];
}
