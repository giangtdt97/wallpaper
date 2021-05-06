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
    public function __construct()
    {
        $this->middleware('auth.apikey');
    }
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
            WallpaperFavorite::where([
                'wallpaper_id' => $id,
                'user_id' => Auth::guard('api')->id() ,
            ])->delete();
            $notification = Wallpaper::where('id', $id)->first();
            $notification->like_count = $notification->like_count-1;
            $notification->save();
            return response()->json(['success' => ['Completed Delete Wallpaper out of List']], 200);
        }else{
            $response['save_wallpaper'] =['success'=>'Save Wallpaper Successfully'];
            WallpaperFavorite::create([
                'wallpaper_id' => $id,
                'user_id' => Auth::guard('api')->id() ,
            ])->first();
            $notification = Wallpaper::where('id', $id)->first();
            $notification->like_count = $notification->like_count+1;
            $notification->save();
        }
        return response()->json($response, Response::HTTP_OK);
    }
}
