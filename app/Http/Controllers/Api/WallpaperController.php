<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WallpaperResource;
use App\Models\Wallpaper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WallpaperController extends Controller
{
    public function index()
    {
        $data = Wallpaper::all();
        $getResource=WallpaperResource::collection($data);
        return $getResource;
    }
    public function show($id)
    {
        $wallpaper=Wallpaper::findOrFail($id);
        return new WallpaperResource($wallpaper);
    }
    public function getFeatured()
    {
        $data = Wallpaper::where('feature',1)->get();
        $getResource=WallpaperResource::collection($data);
        return $getResource;
    }
    public function getPopulared()
    {
        $data = Wallpaper::where('like_count','>=',100)
            ->orderBy('like_count','desc')
            ->paginate(15);
        $getResource=WallpaperResource::collection($data);
        return $getResource;
    }
    public function getNewest()
    {
        $data = Wallpaper::orderBy('created_at','desc')
            ->paginate(15);
        $getResource=WallpaperResource::collection($data);
        return $getResource;
    }
}
