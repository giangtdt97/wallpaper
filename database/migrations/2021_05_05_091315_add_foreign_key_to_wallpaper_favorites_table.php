<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToWallpaperFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallpaper_favorites', function (Blueprint $table) {
            $table->foreign('wallpaper_id')->references('id')
                ->on('wallpapers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallpaper_favorites', function (Blueprint $table) {
            //
        });
    }
}
