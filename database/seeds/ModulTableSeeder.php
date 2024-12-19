<?php

use Illuminate\Database\Seeder;

class ModulTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $moduls = [
        [ 	
        	'nik_trainer'		=> "112",		
			'nama_modul'		=> 'Manajemen Setting',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		],
		[ 
			'nik_trainer'		=> "115",
			'nama_modul'		=> 'Marketing',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		],
		[ 
			'nik_trainer'		=> "116",
			'nama_modul'		=> 'Operasional',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		],
		[ 
			'nik_trainer'		=> "115",
			'nama_modul'		=> 'Billing',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		],
		[ 
			'nik_trainer'		=> "114",
			'nama_modul'		=> 'Account Payable',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		],
		[ 
			'nik_trainer'		=> '114',
			'nama_modul'		=> 'Account Receivable',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		],
		[ 
			'nik_trainer'		=> '116',
			'nama_modul'		=> 'Warehouse Inventory',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		],
		[ 
			'nik_trainer'		=> '116',
			'nama_modul'		=> 'Fleet Yard',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		],
		[ 
			'nik_trainer'		=> '116',
			'nama_modul'		=> 'Driver',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		],
		[ 
			'nik_trainer'		=> '114',
			'nama_modul'		=> 'Finance Accounting',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		],
		[ 
			'nik_trainer'		=> '115',
			'nama_modul'		=> 'Auditor',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		],
		[ 
			'nik_trainer'		=> '116',
			'nama_modul'		=> 'Asset Vehicle',			
			'created_at'		=> '2024-19-12 16:00:00',
			'updated_at'		=> '2024-19-12 16:00:00',			
		]	
		];    

		DB::table('moduls')->insert($moduls);
    }
}
