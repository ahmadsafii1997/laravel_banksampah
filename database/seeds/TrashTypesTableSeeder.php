<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\TrashType;

class TrashTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('trash_types')->insert([
			[
        		'name' => 'alumunium',
        		'description' => 'keterangan sampah alumunium',
        		'admin_id' => '1',
        		'status' => '1'
        	],
        	[
        		'name' => 'besi',
        		'description' => 'keterangan sampah besi',
        		'admin_id' => '1',
        		'status' => '1'
        	],
        	[
        		'name' => 'kertas',
        		'description' => 'keterangan sampah kertas',
        		'admin_id' => '1',
        		'status' => '1'
        	],
        	[
        		'name' => 'botol',
        		'description' => 'keterangan sampah botol',
        		'admin_id' => '1',
        		'status' => '1'
        	],
        	[
        		'name' => 'plastik',
        		'description' => 'keterangan sampah plastik',
        		'admin_id' => '1',
        		'status' => '1'
        	],
        	[
        		'name' => 'lain-lain',
        		'description' => 'sampah lain-lain',
        		'admin_id' => '1',
        		'status' => '1'
        	]
            
        ]);
    }
}
