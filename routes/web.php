<?php

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
//    return view('welcome');
   $w=Visitor::where('device_id','=', 'sdvrvdvvdv')->first();
   if(is_null($w)){
       return 'null';
   }
    echo $w;
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Route::get('feature-wallpapers', 'Admin\FeatureWallpaperController@index')->name('admin.feature');
    Route::get('wallpapers/publish','Voyager\WallpaperController@publish')->name('wallpapers.publish');
    Voyager::routes();
});
