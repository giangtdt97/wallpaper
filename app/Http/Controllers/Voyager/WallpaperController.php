<?php
namespace App\Http\Controllers\Voyager;
use App\Models\Wallpaper;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
class WallpaperController  extends VoyagerBaseController
{
    public function publish(){
        $wallpaper = Wallpaper::where('id', \request("id"))->first();
        $wallpaper->feature = $wallpaper->feature==0?1:0;
        $wallpaper->save();
        return redirect()->back();
    }
}
