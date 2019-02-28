<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateTableAdminGroupPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_group_permission', function (Blueprint $table) {
            $table->integer('gad_id')->unsigned()->index()->unique();
            $table->integer('per_id')->unsigned()->index();
            // $table->string('name',255);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('gad_id', 'fk_admin_group_admin_group_permisson')
                ->references('id')
                ->on('admin_group')
                ->onDelete('cascade');
            $table->foreign('per_id', 'fk_permission_admin_group_permisson')
                ->references('id')
                ->on('permission')
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
        Schema::dropIfExists('admin_group_permission');
    }
}
