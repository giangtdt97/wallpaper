<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Wallpaper extends Model
{
    const FEATURE_ACCEPT = 1;
    const FEATURE_BLOCK = 0;

    public static function getFeatured()
    {
        return [
            self::FEATURE_ACCEPT => 'ACCEPT',
            self::FEATURE_BLOCK => 'BLOCK'
        ];
    }
    public function FeaturedName(){
        $listFeatured = self::getFeatured();
        return $listFeatured[$this->feature] ?? null;
    }
    public function categories(){
        return $this->belongsToMany(Category::class,'category_wallpapers');
    }
    public function users(){
        return $this->belongsToMany(User::class,'wallpaper_favorites');
    }
    public function visitors(){
        return $this->belongsToMany(Visitor::class,'visitor_favorites');
    }
}
