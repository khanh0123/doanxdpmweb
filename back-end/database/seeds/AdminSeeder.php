<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = DB::table('admin')->get();
    	if(count($result) == 0){
    		DB::table('admin')->insert([
    			'gad_id' => DB::table('admin_group')->where('name','Super Admin')->get()[0]->id,
    			'password' => hash("sha256", md5('123123')),
    			'username' => 'Admin',
    			'status' => 1,
    			]);
    	}
    }
}
