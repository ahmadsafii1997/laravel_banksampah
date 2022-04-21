<?php

use Illuminate\Database\Seeder;
use App\Director;

class DirectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Director::create([
            'name' => 'Direktur1',
            'email' => 'direktur1@gmail.com',
            'password' => bcrypt('direktur1'),
            'status' => '1'
        ]);
    }
}
