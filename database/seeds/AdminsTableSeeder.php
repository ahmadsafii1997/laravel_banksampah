<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Ahmad Safi',
            'email' => 'ahmadsafi@gmail.com',
            'password' => bcrypt('ahmadsafi')
        ]);
    }
}
