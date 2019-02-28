<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class Admin_Group_Permission_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = DB::table('admin_group_permission')->get();
    	if(count($result) == 0){
    		DB::table('admin_group_permission')->insert([
    			[
    			'gad_id' => DB::table('admin_group')->where('name','Demo')->get()[0]->id,
    			'per_id' => DB::table('permission')->where('name','Đọc')->get()[0]->id,
    			// 'name' => 'Xem',
    			],
    			[
    			'gad_id' => DB::table('admin_group')->where('name','Writer')->get()[0]->id,
    			'per_id' => DB::table('permission')->where('name','Ghi')->get()[0]->id,
    			// 'name' => 'Thêm',
    			],
    			[
    			'gad_id' => DB::table('admin_group')->where('name','Editer')->get()[0]->id,
    			'per_id' => DB::table('permission')->where('name','Sửa')->get()[0]->id,
    			// 'name' => 'Sửa',
    			],
    			[
    			'gad_id' => DB::table('admin_group')->where('name','Editer With Delete')->get()[0]->id,
    			'per_id' => DB::table('permission')->where('name','Xóa')->get()[0]->id,
    			// 'name' => 'Xóa',
    			],
    			[
    			'gad_id' => DB::table('admin_group')->where('name','Super Admin')->get()[0]->id,
    			'per_id' => DB::table('permission')->where('name','Quản Trị')->get()[0]->id,
    			// 'name' => 'Quản Trị',
    			],
    		]);
    	}
    }
}
