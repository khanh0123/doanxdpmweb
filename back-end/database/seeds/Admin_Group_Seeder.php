<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class Admin_Group_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = DB::table('admin_group')->get();
    	if(count($result) == 0){
    		DB::table('admin_group')->insert([
    			[
    			'name' => 'Super Admin',
    			],
    			[
    			'name' => 'Editer With Delete',
    			],
    			[
    			'name' => 'Editer',
    			],
    			[
    			'name' => 'Writer',
    			],
    			[
    			'name' => 'Demo',
    			],
    		]);
    	}
    }
}
