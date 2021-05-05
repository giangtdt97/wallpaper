<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WallpaperFavorite extends Model
{
    protected $fillable = [
        'user_id', 'wallpaper_id'
    ];
    protected $table ='wallpaper_favorites';
}
