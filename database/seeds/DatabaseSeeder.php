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
        // $this->call(UserSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(TrashTypesTableSeeder::class);
        $this->call(TrashPricesTableSeeder::class);
        $this->call(DirectorsTableSeeder::class);
    }
}
