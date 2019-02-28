<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EpisodeVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episode_video', function (Blueprint $table) {
            $table->integer('epi_id')->unsigned()->index();
            $table->integer('video_id')->unsigned()->index();
            $table->foreign('epi_id', 'fk_episode_video_episode')->references('id')->on('episode')->onDelete('cascade');
            $table->foreign('video_id', 'fk_episode_video_video')->references('id')->on('video')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episode_video');
    }
}
