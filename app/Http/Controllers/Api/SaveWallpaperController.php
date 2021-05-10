<?php

namespace App\Http\Controllers\Api;

use App\Models\Wallpaper;
use App\Models\WallpaperFavorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SaveWallpaperController extends Controller
{
    public function storeWallpaper($id)
    {
        if(!Auth::guard('api')->check()){
            return response()->json(['errors' => ['Please login to save this Wallpaper to your List']], 400);
        }
        $wallpaperFavorite= WallpaperFavorite::where([
            'wallpaper_id' => $id,
            'user_id' => Auth::guard('api')->id() ,
        ])->first();
        $response = array();
        if($wallpaperFavorite){
            return response()->json(['warning' => ['This Wallpaper has already in your List']], 200);
        }else{
            $response['save_wallpaper'] =['success'=>'Save Wallpaper Successfully'];
            WallpaperFavorite::create([
                'wallpaper_id' => $id,
                'user_id' => Auth::guard('api')->id() ,
            ])->first();
            $wallpaper = Wallpaper::where('id', $id)->first();
            $wallpaper->increment('like_count');
        }
        return response()->json($response, Response::HTTP_OK);
    }
    public function unSavedWallpaper($id)
    {
        if(!Auth::guard('api')->check()){
            return response()->json(['errors' => ['Please login to save this Wallpaper to your List']], 400);
        }
        $wallpaperFavorite= WallpaperFavorite::where([
            'wallpaper_id' => $id,
            'user_id' => Auth::guard('api')->id() ,
        ])->first();
        $response = array();
        if($wallpaperFavorite){
            WallpaperFavorite::where([
                'wallpaper_id' => $id,
                'user_id' => Auth::guard('api')->id() ,
            ])->delete();
            $wallpaper = Wallpaper::where('id', $id)->first();
            $wallpaper->decrement('like_count');
            return response()->json(['success' => ['Completely Delete this Wallpaper out of your List']], 200);
        }else{
            $response['warning'] =['success'=>'This Wallpaper is not in your list'];
        }
        return response()->json($response, Response::HTTP_OK);
    }
}
