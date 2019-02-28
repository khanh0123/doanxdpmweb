<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateTableUserEndTimesEpisode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_end_times_episode', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->integer('epi_id')->unsigned()->index();
            $table->double('time_watched');
            $table->double('time_current');
            $table->foreign('user_id', 'fk_user_end_times_episode_user')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('epi_id', 'fk_user_end_times_episode_episode')->references('id')->on('episode')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_end_times_episode');
    }
}
