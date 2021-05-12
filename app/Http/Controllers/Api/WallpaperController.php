<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\WallpaperResource;
use App\Models\Visitor;
use App\Models\VisitorFavorite;
use App\Models\Wallpaper;
use App\Models\WallpaperFavorite;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WallpaperController extends Controller
{
    public function show(Request $request)
    {
        $wallpaper = Wallpaper::findOrFail($request->wallpaper_id);
        $wallpaper->increment('view_count');
        $visitorFavorite = VisitorFavorite::where([
            'wallpaper_id' => $request->wallpaper_id,
            'visitor_id' => Visitor::where('device_id', $request->device_id)->value('id')])->first();
        if($visitorFavorite){
            return response()->json([
                'categories' =>
                    CategoryResource::collection($wallpaper->categories),
                'id' => $wallpaper->id,
                'name' => $wallpaper->name,
                'thunbnail_image' => asset('storage/' . $wallpaper->thumbnail_image),
                'image' => asset('storage/' . $wallpaper->image),
                'liked' => 1,
                'like_count' => $wallpaper->like_count,
                'views' => $wallpaper->view_count,
                'feature' => $wallpaper->feature,
                'created_at' => $wallpaper->created_at->format('d/m/Y'),
            ]);
        }else{
            return response()->json([
                'categories' =>
                    CategoryResource::collection($wallpaper->categories),
                'id' => $wallpaper->id,
                'name' => $wallpaper->name,
                'thunbnail_image' => asset('storage/' . $wallpaper->thumbnail_image),
                'image' => asset('storage/' . $wallpaper->image),
                'liked' => 0,
                'like_count' => $wallpaper->like_count,
                'views' => $wallpaper->view_count,
                'feature' => $wallpaper->feature,
                'created_at' => $wallpaper->created_at->format('d/m/Y'),
            ]);
        }
    }

    public function getFeatured()
    {
        if (getIp()) {
            $data = Wallpaper::where('feature', 1)
                ->orderBy('like_count', 'desc')
                ->whereHas('categories', function ($q) {
                    $q->where('checked_ip', '=', 1);
                })
                ->inRandomOrder()
                ->take(5)->get();
            $getResource = WallpaperResource::collection($data);
            return $getResource;
        } else {
            $data = Wallpaper::where('feature', 1)
                ->orderBy('like_count', 'desc')
                ->whereHas('categories', function ($q) {
                    $q->where('checked_ip', '=', 0);
                })
                ->inRandomOrder()
                ->take(5)->get();
            $getResource = WallpaperResource::collection($data);
            return $getResource;
        }
    }

    public function getPopulared()
    {
        if (getIp()){
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

    public function getNewest()
    {
        if (getIp()){
            $data = Wallpaper::orderBy('created_at','desc')
                ->whereHas('categories', function ($q)
                {
                    $q->where('checked_ip','=', 1);
                })
                ->paginate(11);
            $getResource=WallpaperResource::collection($data);
            return $getResource;
        }else {
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
