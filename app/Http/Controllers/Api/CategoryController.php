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
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) == false){
                        $data = Category::where('checked_ip',1)->get();
                        $getResource=CategoryResource::collection($data);
                        return $getResource;
                    }else{
                        $data = Category::where('checked_ip',0)->get();
                        $getResource=CategoryResource::collection($data);
                        return $getResource;
                    }

                }
            }
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
