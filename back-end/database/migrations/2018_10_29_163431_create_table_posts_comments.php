<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateTablePostsComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_comments', function (Blueprint $table) {
            $table->integer('post_id')->unsigned()->index();
            $table->integer('comment_id')->unsigned()->index();


            $table->foreign('post_id', 'fk_posts_comments_posts')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

            $table->foreign('comment_id', 'fk_posts_comments_comments')
                ->references('id')
                ->on('comments')
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
        Schema::dropIfExists('posts_comments');
    }
}
