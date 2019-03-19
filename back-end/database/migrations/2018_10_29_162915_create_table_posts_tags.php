<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateTablePostsTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_tags', function (Blueprint $table) {
            // $table->collation = 'utf8_unicode_ci';
            // $table->charset = 'utf8';

            $table->integer('post_id')->unsigned()->index();
            $table->integer('tag_id')->unsigned()->index();

            $table->foreign('post_id', 'fk_posts_tags_posts')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade'); 

            $table->foreign('tag_id', 'fk_posts_tags_tags')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_tags');
    }
}
