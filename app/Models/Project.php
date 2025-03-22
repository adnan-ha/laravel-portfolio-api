<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'link',
        'image',
        'user_id',
    ];

    //
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return url("storage/" . $this->image);
        }
        return null;
    }
}
