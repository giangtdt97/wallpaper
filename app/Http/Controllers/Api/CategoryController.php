<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\WallpaperResource;
use App\Models\Category;
use App\Models\Wallpaper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.apikey');
    }
    public function index()
    {
        $data = Category::all();
        $getResource=CategoryResource::collection($data);
        return $getResource;
    }
    public function getWallpapers($id)
    {
        $stories = Category::findOrFail($id)
            ->wallpapers()
            ->orderBy('like_count','desc')
            ->paginate(15);
        $getResource=WallpaperResource::collection($stories);
        return $getResource;
    }
}
