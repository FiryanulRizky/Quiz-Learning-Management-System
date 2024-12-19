<?php

use Illuminate\Database\Seeder;

class TraineesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() 
    {
        $trainees = [
        [ 
			'nik_trainee'		=> '121',
			'nama_trainee'		=> 'Muhammad Raihan ',
			'email_trainee'		=> 'raihan@tcontinent.com',
			'no_hp_trainee'		=> '082176074036',
			'ttl_trainee'			=> 'Bandung, 26 Mei 1999',
			'jns_kelamin_trainee'	=> 'Laki - laki',
			'alamat_trainee'		=> 'Sukarame Perum Korpri',
			'departemen_trainee'		=> 'Operasional',
			'foto_trainee'		=> 'foto .jpg',
			'status_trainee'		=> 'Aktif',
			'id_user'			=> '7',
			'created_at'		=> '2024-01-12 16:00:00',
			'updated_at'		=> '2024-01-12 16:00:00',			
		],
		[ 
			'nik_trainee'		=> '122',
			'nama_trainee'		=> 'Abda Syakura Taqwadin',
			'email_trainee'		=> 'abda@tcontinent.com',
			'no_hp_trainee'		=> '081215869294',
			'ttl_trainee'			=> 'Aceh, 34 Juli 1998',
			'jns_kelamin_trainee'	=> 'Laki - laki',
			'alamat_trainee'		=> 'Kavling Raya Pramuka',
			'departemen_trainee'		=> 'Marketing',
			'foto_trainee'		=> 'user1-128x128.jpg',
			'status_trainee'		=> 'Aktif',
			'id_user'			=> '8',
			'created_at'		=> '2024-01-12 16:00:00',
			'updated_at'		=> '2024-01-12 16:00:00',			
		]		
		];    

		DB::table('trainees')->insert($trainees);
    }
}
