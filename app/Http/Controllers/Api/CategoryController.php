<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\WallpaperResource;
use App\Models\Category;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    public function index()
    {
        if(getIp()){
            $data = Category::where('checked_ip',1)->get();
            $getResource=CategoryResource::collection($data);
            return $getResource;
        }else{
            $data = Category::where('checked_ip',0)->get();
            $getResource=CategoryResource::collection($data);
            return $getResource;
        }
    }
    public function getWallpapers($id)
    {
        $stories = Category::findOrFail($id)
            ->wallpapers()
            ->orderBy('like_count', 'desc')
            ->paginate(11);
        $getResource = WallpaperResource::collection($stories);
        return $getResource;
    }
}
