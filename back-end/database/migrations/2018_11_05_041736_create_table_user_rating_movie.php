<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateTableUserRatingMovie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rating_movie', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();            
            $table->integer('mov_id')->unsigned()->index();          
            $table->integer('rating');
            $table->foreign('user_id','fk_user_rating_movie_user')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('mov_id', 'fk_user_rating_movie_movie')->references('id')->on('movie')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_rating_movie');
    }
}
