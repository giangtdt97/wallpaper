<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorFavorite extends Model
{
    protected $fillable = [
        'visitor_id', 'wallpaper_id'
    ];
    protected $table ='visitor_favorites';
}
