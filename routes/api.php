<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
if (App::environment('production', 'staging')) {
    URL::forceScheme('https');
}
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
Route::get('categories', 'Api\CategoryController@index');
Route::get('categories/{category_id}/wallpapers', 'Api\CategoryController@getWallpapers');
Route::post('wallpaper-detail', 'Api\WallpaperController@show');
Route::get('wallpapers/featured', 'Api\WallpaperController@getFeatured');
Route::get('wallpapers/popular', 'Api\WallpaperController@getPopulared');
Route::get('wallpapers/newest', 'Api\WallpaperController@getNewest');
Route::post('wallpaper-favorite', 'Api\FavoriteController@likeWallpaper')->middleware('auth.apikey');
Route::post('wallpaper-favorite-unsaved', 'Api\FavoriteController@disLikeWallpaper')->middleware('auth.apikey');
Route::post('favorite', 'Api\FavoriteController@getSaved');
