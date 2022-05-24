<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'voto',
        'whovoted'
    ];
    public function images() {
        return $this->belongsToMany('App\Models\Image', 'vote_image');
    }
}
