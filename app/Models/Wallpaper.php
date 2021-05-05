<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallpaper extends Model
{
    public function categories(){
        return $this->belongsToMany(Category::class,'category_wallpapers');
    }
    public function users(){
        return $this->belongsToMany(User::class,'wallpaper_favorites');
    }
}
