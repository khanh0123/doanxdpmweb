<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$result = DB::table('permission')->get();
    	if(count($result) == 0){
    		DB::table('permission')->insert([
    			[
    			'name' => 'Đọc',
    			'canRead' => 1,
    			'canWrite' => 0,
    			'canUpdate' => 0,
    			'canDelete' => 0,
    			'isAdmin' => 0
    			],
    			[
    			'name' => 'Ghi',
    			'canRead' => 1,
    			'canWrite' => 1,
    			'canUpdate' => 0,
    			'canDelete' => 0,
    			'isAdmin' => 0
    			],
    			[
    			'name' => 'Sửa',
    			'canRead' => 1,
    			'canWrite' => 1,
    			'canUpdate' => 1,
    			'canDelete' => 0,
    			'isAdmin' => 0
    			],
    			[
    			'name' => 'Xóa',
    			'canRead' => 1,
    			'canWrite' => 1,
    			'canUpdate' => 1,
    			'canDelete' => 1,
    			'isAdmin' => 0
    			],
    			[
    			'name' => 'Quản Trị',
    			'canRead' => 1,
    			'canWrite' => 1,
    			'canUpdate' => 1,
    			'canDelete' => 1,
    			'isAdmin' => 1
    			],
    		]);
    	}
    	
    }
}
