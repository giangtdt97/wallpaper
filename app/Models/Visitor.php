<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'device_id'
    ];
    public function wallpapers(){
        return $this->belongsToMany(Wallpaper::class,'visitor_favorites');
    }
}
