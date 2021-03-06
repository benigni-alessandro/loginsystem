<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'title',
        'content',
        'cover',
        'no_visibility_list'
    ];
    
    public function users()
   {
    return $this->belongsToMany('App\Models\User');
   }

   public function tags()
   {
    return $this->belongsToMany('App\Models\Tag');
   }

   public function votes() {
    return $this->belongsToMany('App\Models\Vote');
}
   
   
}
