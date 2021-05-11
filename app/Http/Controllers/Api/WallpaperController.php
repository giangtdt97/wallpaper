<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\WallpaperResource;
use App\Models\Wallpaper;
use App\Models\WallpaperFavorite;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WallpaperController extends Controller
{
//    public function index()
//    {
//        $data = Wallpaper::all();
//        $getResource=WallpaperResource::collection($data);
//        return $getResource;
//    }

    public function show($id)
    {
        $wallpaper=Wallpaper::findOrFail($id);
        $wallpaper->increment('view_count');
        $wallpaperFavorite = WallpaperFavorite::where([
            'wallpaper_id' => $id,
            'user_id' => Auth::guard('api')->id(),
        ])->first();
        if($wallpaperFavorite){
            return response()->json([
                'categories'=>
                    CategoryResource::collection( $wallpaper->categories),
                'id' =>  $wallpaper->id,
                'name' =>  $wallpaper->name,
                'thunbnail_image' => asset('storage/'. $wallpaper->thumbnail_image),
                'image' => asset('storage/'. $wallpaper->image),
                'liked'=>1,
                'like_count' =>  $wallpaper->like_count,
                'views' =>  $wallpaper->view_count,
                'feature' =>  $wallpaper->feature,
                'created_at' =>  $wallpaper->created_at->format('d/m/Y'),
            ]);
        }else{
            return response()->json([
                'categories'=>
                    CategoryResource::collection( $wallpaper->categories),
                'id' =>  $wallpaper->id,
                'name' =>  $wallpaper->name,
                'thunbnail_image' => asset('storage/'. $wallpaper->thumbnail_image),
                'image' => asset('storage/'. $wallpaper->image),
                'liked'=>0,
                'like_count' =>  $wallpaper->like_count,
                'views' =>  $wallpaper->view_count,
                'feature' =>  $wallpaper->feature,
                'created_at' =>  $wallpaper->created_at->format('d/m/Y'),
            ]);
        }

    }

    public function getFeatured()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) == false){
                        $data = Wallpaper::where('feature',1)
                            ->orderBy('like_count','desc')
                            ->whereHas('categories', function ($q)
                            {
                                $q->where('checked_ip','=', 1);
                            })
                            ->inRandomOrder()
                            ->take(5)->get();
                        $getResource=WallpaperResource::collection($data);
                        return $getResource;
                    }else{
                        $data = Wallpaper::where('feature',1)
                            ->orderBy('like_count','desc')
                            ->whereHas('categories', function ($q)
                            {
                                $q->where('checked_ip','=', 0);
                            })
                            ->inRandomOrder()
                            ->take(5)->get();
                        $getResource=WallpaperResource::collection($data);
                        return $getResource;
                    }

                }
            }
        }
    }

    public function getPopulared()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) == false){
                        $data = Wallpaper::where('like_count','>=',1)
                            ->orderBy('like_count','desc')
                            ->whereHas('categories', function ($q)
                            {
                                $q->where('checked_ip','=', 1);
                            })
                            ->paginate(11);
                        $getResource=WallpaperResource::collection($data);
                        return $getResource;
                    }else{
                        $data = Wallpaper::where('like_count','>=',1)
                            ->orderBy('like_count','desc')
                            ->whereHas('categories', function ($q)
                            {
                                $q->where('checked_ip','=', 0);
                            })
                            ->paginate(11);
                        $getResource=WallpaperResource::collection($data);
                        return $getResource;
                    }

                }
            }
        }
    }

    public function getNewest()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) == false){
                        $data = Wallpaper::orderBy('created_at','desc')
                            ->whereHas('categories', function ($q)
                            {
                                $q->where('checked_ip','=', 1);
                            })
                            ->paginate(11);
                        $getResource=WallpaperResource::collection($data);
                        return $getResource;
                    }else{
                        $data = Wallpaper::orderBy('created_at','desc')
                            ->whereHas('categories', function ($q)
                            {
                                $q->where('checked_ip','=', 0);
                            })
                            ->paginate(11);
                        $getResource=WallpaperResource::collection($data);
                        return $getResource;
                    }

                }
            }
        }
    }
}
