<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWallpaperFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallpaper_favorites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('wallpaper_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('user_id')->unsigned()->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallpaper_favorites');
    }
}
