<?php

use Illuminate\Database\Seeder;

class TrainersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trainers = [
			[ 
				'nik_trainer'		=> '111',
				'nama_trainer'		=> 'Muhammad Firyanul Rizky',
				'ttl_trainer'			=> 'Kabupaten Tuban, 29 Maret 1999',
				'jns_kelamin_trainer'	=> 'Laki-Laki',
				'agama_trainer'	=> 'Islam',
				'no_telp_trainer'		=> '0895606181117',
				'email_trainer'		=> 'rizki@tcontinent.com',									
				'alamat_trainer'		=> 'Jl. Tebet Dalam IV',
				'jabatan_trainer'		=> 'IT Software Development',
				'foto_trainer'		=> 'TI-RIZKI.JPG',
				'status_trainer'		=> 'Aktif',
				'id_user'			=> '1',
				'created_at'		=> '2024-12-18 16:00:00',
				'updated_at'		=> '2024-12-18 16:00:00',			
			],
			[ 
				'nik_trainer'		=> '112',
				'nama_trainer'		=> 'Gusti Denata Bagus Narawangsa',
				'ttl_trainer'			=> 'Surabaya, 26 Mei 2001',
				'jns_kelamin_trainer'	=> 'Laki-Laki',
				'agama_trainer'	=> 'Islam',
				'no_telp_trainer'		=> '081279098909',
				'email_trainer'		=> 'gusti@tcontinent.com',									
				'alamat_trainer'		=> 'Tebet Raya',
				'jabatan_trainer'		=> 'IT Helpdesk',
				'foto_trainer'		=> 'TI-GUSTI.JPG',
				'status_trainer'		=> 'Aktif',
				'id_user'			=> '2',
				'created_at'		=> '2024-11-28 16:00:00',
				'updated_at'		=> '2024-11-28 16:00:00',			
			],
			[ 
				'nik_trainer'		=> '113',
				'nama_trainer'		=> 'Ade Nasfudin',
				'ttl_trainer'			=> 'Bandung, 26 Mei 1970',
				'jns_kelamin_trainer'	=> 'Perempuan',
				'agama_trainer'	=> 'Islam',
				'no_telp_trainer'		=> '081279098909',
				'email_trainer'		=> 'ade@tcontinent.com',									
				'alamat_trainer'		=> 'Tebet Raya',
				'jabatan_trainer'		=> 'General Manajer',
				'foto_trainer'		=> 'MNJ-ADE.JPG',
				'status_trainer'		=> 'Aktif',
				'id_user'			=> '3',
				'created_at'		=> '2024-11-28 16:00:00',
				'updated_at'		=> '2024-11-28 16:00:00',			
			],
			[ 
				'nik_trainer'		=> '114',
				'nama_trainer'		=> 'Tri Joko Yani',
				'ttl_trainer'			=> 'Bandung, 26 Mei 1970',
				'jns_kelamin_trainer'	=> 'Laki-Laki',
				'agama_trainer'	=> 'Islam',
				'no_telp_trainer'		=> '081279098909',
				'email_trainer'		=> 'tri@tcontinent.com',									
				'alamat_trainer'		=> 'Tebet Raya',
				'jabatan_trainer'		=> 'Manajer Finance',
				'foto_trainer'		=> 'MNJ-TRI.JPG',
				'status_trainer'		=> 'Aktif',
				'id_user'			=> '4',
				'created_at'		=> '2024-11-28 16:00:00',
				'updated_at'		=> '2024-11-28 16:00:00',			
			],
			[ 
				'nik_trainer'		=> '115',
				'nama_trainer'		=> 'Lilis Sugiarti',
				'ttl_trainer'			=> 'Bandung, 26 Mei 1987',
				'jns_kelamin_trainer'	=> 'Perempuan',
				'agama_trainer'	=> 'Islam',
				'no_telp_trainer'		=> '081279098909',
				'email_trainer'		=> 'lilis@tcontinent.com',									
				'alamat_trainer'		=> 'Tebet Raya',
				'jabatan_trainer'		=> 'Nasional Manajer',
				'foto_trainer'		=> 'MNJ-LILIS.JPG',
				'status_trainer'		=> 'Aktif',
				'id_user'			=> '5',
				'created_at'		=> '2024-11-28 16:00:00',
				'updated_at'		=> '2024-11-28 16:00:00',			
			],
			[ 
				'nik_trainer'		=> '116',
				'nama_trainer'		=> 'Fredy Hutagalung',
				'ttl_trainer'			=> 'Bandung, 26 Mei 1970',
				'jns_kelamin_trainer'	=> 'Laki-Laki',
				'agama_trainer'	=> 'Islam',
				'no_telp_trainer'		=> '081279098909',
				'email_trainer'		=> 'fredy@tcontinent.com',									
				'alamat_trainer'		=> 'Tebet Raya',
				'jabatan_trainer'		=> 'Manajer Operasional',
				'foto_trainer'		=> 'MNJ-FREDY.JPG',
				'status_trainer'		=> 'Aktif',
				'id_user'			=> '6',
				'created_at'		=> '2024-11-28 16:00:00',
				'updated_at'		=> '2024-11-28 16:00:00',			
			]	
		];   
		DB::table('trainers')->insert($trainers);
    }
}
