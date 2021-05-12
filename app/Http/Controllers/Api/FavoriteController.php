<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WallpaperResource;
use App\Models\Visitor;
use App\Models\VisitorFavorite;
use App\Models\Wallpaper;
use App\Models\WallpaperFavorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function likeWallpaper(Request $request)
    {
                    if (getIp()) {
                        return response()->json([
                            'message' => 'not real address'
                        ]);
                    } else {
                        $visitor=Visitor::where('device_id',$request->device_id)->first();
                        if(!$visitor){
                            Visitor::create([
                                'device_id'=>$request->device_id
                            ]);
                        }
                        $visitorFavorite = VisitorFavorite::where([
                            'wallpaper_id' => $request->wallpaper_id,
                            'visitor_id' => Visitor::where('device_id', $request->device_id)->value('id')])->first();
                        $response = array();
                        if ($visitorFavorite) {
                            return response()->json(['warning' => ['This Wallpaper has already in your List']], 200);
                        } else {
                            $response['save_wallpaper'] = ['success' => 'Save Wallpaper Successfully'];
                            VisitorFavorite::create([
                                'wallpaper_id' =>  $request->wallpaper_id,
                                'visitor_id' => Visitor::where('device_id', $request->device_id)->value('id')
                            ])->first();
                            $wallpaper = Wallpaper::where('id',$request->wallpaper_id)->first();
                            $wallpaper->increment('like_count');
                        }
                        return response()->json($response, Response::HTTP_OK);
                    }
                }

    public function disLikeWallpaper(Request $request)
    {
        if (getIp()) {
            return response()->json([
                'message' => 'not real address'
            ]);
        } else {
            $visitorFavorite = VisitorFavorite::where([
                'wallpaper_id' => $request->wallpaper_id,
                'visitor_id' => Visitor::where('device_id', $request->device_id)->value('id')])->first();
            $response = array();
            if ($visitorFavorite) {
                VisitorFavorite::where([
                    'wallpaper_id' => $request->wallpaper_id,
                    'visitor_id' => Visitor::where('device_id', $request->device_id)->value('id')
                ])->delete();
                $wallpaper = Wallpaper::where('id', $request->wallpaper_id)->first();
                $wallpaper->decrement('like_count');
                return response()->json(['success' => ['Completely Delete this Wallpaper out of your List']], 200);
            } else {
                $response['warning'] = ['success' => 'This Wallpaper is not in your list'];
            }
            return response()->json($response, Response::HTTP_OK);
        }
    }
    public function getSaved(Request $request)
    {
        $visitor= Visitor::where('device_id', $request->device_id)->first();
        try{
        $data = Visitor::findOrFail($visitor->id)
            ->wallpapers()
            ->paginate(15);
        $getResource=WallpaperResource::collection($data);
        if($data->isEmpty()){
            return response()->json([], 200);
        }
        return $getResource;
        }catch(\Exception $e) {
            return response()->json([], 200);
        }
    }
}
