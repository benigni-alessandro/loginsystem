<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'title',
        'content',
        'whomadeit',
        'user_id_image',
        'image_id',
    ];
    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }
}
