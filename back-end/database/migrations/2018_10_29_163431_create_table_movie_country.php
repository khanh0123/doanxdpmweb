<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateTableMovieCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_country', function (Blueprint $table) {
            $table->string('cou_id',255);
            $table->integer('mov_id')->unsigned()->index();
            $table->foreign('cou_id', 'fk_movie_country_country')->references('id')->on('country')->onDelete('cascade');
            $table->foreign('mov_id', 'fk_movie_country_movie')->references('id')->on('movie')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_country');
    }
}
