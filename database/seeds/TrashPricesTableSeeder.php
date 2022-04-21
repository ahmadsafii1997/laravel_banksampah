<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\TrashPrice;

class TrashPricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('trash_prices')->insert([
			[
        		'name' => 'plat',
        		'description' => 'lempengan alumunium tebal',
        		'trashtype_id' => '1',
        		'price' => '9500',
        		'unit' => 'kg',
        		'admin_id' => '1',
        		'status' => '1'
        	],
			[
				'name' => 'panci',
				'description' => 'panci bekas',
				'trashtype_id' => '1',
				'price' => '10000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'kaleng alumunium',
				'description' => 'kaleng pocari, sprite',
				'trashtype_id' => '1',
				'price' => '9000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			], 
			[
				'name' => 'wajan alumunium',
				'description' => 'wajan alumunium',
				'trashtype_id' => '1',
				'price' => '6000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],   
			[
				'name' => 'besi super / tebal',
				'description' => 'besi yang tebal, rantai, gear',
				'trashtype_id' => '2',
				'price' => '1700',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'paku',
				'description' => 'paku bekas',
				'trashtype_id' => '2',
				'price' => '900',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'kaleng',
				'description' => 'kaleng susu, kawat',
				'trashtype_id' => '2',
				'price' => '500',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],  
			[
				'name' => 'seng',
				'description' => 'seng bekas',
				'trashtype_id' => '2',
				'price' => '100',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],     
			[
				'name' => 'kardus bagus',
				'description' => 'kardus warna coklat yang masih bagus',
				'trashtype_id' => '3',
				'price' => '1200',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'kardus jelek',
				'description' => 'kardus berminyak, kardus tebal warna putih',
				'trashtype_id' => '3',
				'price' => '900',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],  
			[
				'name' => 'koran',
				'description' => 'koran bekas',
				'trashtype_id' => '3',
				'price' => '1500',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],   
			[
				'name' => 'kertas HVS',
				'description' => 'kertas putih dengan atau tanpa tinta',
				'trashtype_id' => '3',
				'price' => '1800',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			], 
			[
				'name' => 'kertas buram / LKS',
				'description' => 'kertas yang berwarna coklat / abu2',
				'trashtype_id' => '3',
				'price' => '800',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'sak semen',
				'description' => 'kemasan semen',
				'trashtype_id' => '3',
				'price' => '1000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],    
			[
				'name' => 'duplek',
				'description' => 'kertas rokok, kertas jelek, karton warna, brosur',
				'trashtype_id' => '3',
				'price' => '400',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'botol sirup',
				'description' => 'sisa botol sirup',
				'trashtype_id' => '4',
				'price' => '100',
				'unit' => 'pcs',
				'admin_id' => '1',
				'status' => '1'
			], 
			[
				'name' => 'botol kecap / saos',
				'description' => 'botol bekas kecap',
				'trashtype_id' => '4',
				'price' => '400',
				'unit' => 'pcs',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'beling',
				'description' => 'pecahan lampu, botol',
				'trashtype_id' => '4',
				'price' => '50',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'botol kecil putih',
				'description' => 'botol minuman you c1000',
				'trashtype_id' => '4',
				'price' => '200',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'plastik putih bening',
				'description' => 'plastik bening tanpa sablon / tulisan',
				'trashtype_id' => '5',
				'price' => '1000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],  
			[
				'name' => 'plastik kresek',
				'description' => 'plastik bekas wadah barang',
				'trashtype_id' => '5',
				'price' => '4000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			], 
			[
				'name' => 'plastik sablon tipis',
				'description' => 'plastik bekas kemasan tanpa lapisan foil',
				'trashtype_id' => '5',
				'price' => '300',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			], 
			[
				'name' => 'plastik kemasan foil',
				'description' => 'plastik bekas yang ada lapisan foil',
				'trashtype_id' => '5',
				'price' => '25',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'plastik sablon tebal / minyak',
				'description' => 'plastik bekas minyak, softener',
				'trashtype_id' => '5',
				'price' => '200',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			], 
			[
				'name' => 'gelas minuman',
				'description' => 'plastik gelas bening putih tanpa sablon',
				'trashtype_id' => '5',
				'price' => '4000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'botol putih',
				'description' => 'plastik botol minuman',
				'trashtype_id' => '5',
				'price' => '3000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],    
			[
				'name' => 'botol minuman warna',
				'description' => 'botol bekas kemasan minuman berwarna',
				'trashtype_id' => '5',
				'price' => '1000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],    
			[
				'name' => 'tutup galon / tutup botol minuman',
				'description' => 'tutup bekas galon / minuman',
				'trashtype_id' => '5',
				'price' => '3000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			], 
			[
				'name' => 'plastik keras',
				'description' => 'plastik mainan anak, helm',
				'trashtype_id' => '5',
				'price' => '150',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			], 
			[
				'name' => 'tali plastik',
				'description' => 'tali untuk packing',
				'trashtype_id' => '5',
				'price' => '400',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'keping CD',
				'description' => 'keping CD atau DVD',
				'trashtype_id' => '6',
				'price' => '2000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],
			[
				'name' => 'jelantah',
				'description' => 'bening atau hitam',
				'trashtype_id' => '6',
				'price' => '2000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],  
			[
				'name' => 'selang',
				'description' => 'selang untuk pancuran air',
				'trashtype_id' => '6',
				'price' => '150',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],     
			[
				'name' => 'paralon',
				'description' => 'pipa bekas',
				'trashtype_id' => '6',
				'price' => '150',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],  
			[
				'name' => 'perunggu',
				'description' => 'keran air, kampas rem (tidak menempel dengan magnet)',
				'trashtype_id' => '6',
				'price' => '7000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			], 
			[
				'name' => 'gembos',
				'description' => 'sandal dan sepatu',
				'trashtype_id' => '6',
				'price' => '500',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			], 
			[
				'name' => 'kabel',
				'description' => 'kabel listrik',
				'trashtype_id' => '6',
				'price' => '1000',
				'unit' => 'kg',
				'admin_id' => '1',
				'status' => '1'
			],      
        ]);  
    }
}
