<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{

    protected $fillable = [
        'title', 'description', 'image', 'price'
    ];


    public function getImageUrlAttribute()
    {
        return preg_replace("/([^:]\/)\/+/", "$1", Storage::disk('public')->url($this->image));
    }
}
