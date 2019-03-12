<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateTablePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            // $table->collation = 'utf8_unicode_ci';
            // $table->charset = 'utf8';
            $table->increments('id');
            $table->string('title',255);
            $table->string('image',255);
            $table->text('content');
            $table->string('slug',255);
            $table->text('short_des');
            $table->text('long_des');
            $table->integer('type_id')->unsigned()->index();
            $table->integer('ad_id')->unsigned()->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // $table->foreign('type_id', 'fk_posts_posts_type')
            //     ->references('id')
            //     ->on('posts_type')
            //     ->onDelete('cascade');  

            $table->foreign('ad_id', 'fk_posts_admin')
                ->references('id')
                ->on('admin')
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
        Schema::dropIfExists('posts');
    }
}
