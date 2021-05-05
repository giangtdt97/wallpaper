<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryWallpaper extends Model
{
    protected $fillable = [
        'category_id', 'wallpaper_id'
    ];
    protected $table ='category_wallpapers';
}
