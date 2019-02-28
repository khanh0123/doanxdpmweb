<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	PermissionSeeder::class,
        	Admin_Group_Seeder::class,
        	Admin_Group_Permission_Seeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            CountriesSeeder::class,
            GenresSeeder::class,
            ConfigSeeder::class,
            MovieSeeder::class,
        	JsonTableSeeder::class,
            MenuSeeder::class,
        ]);
    }
}
