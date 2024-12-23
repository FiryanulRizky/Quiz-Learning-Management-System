<?php

use Illuminate\Database\Seeder;

class PengumumansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengumumans = [
		[
			'judul'	=> 'Sosialisai E-Learning Solog',
			'deskripsi'	=> 'Diumumkan kepada Seluruh Trainee departemen Operasional agar mengikuti acara Sosialisasi E-Learnig Solog pada :
							Hari : Senin
							Pukul : 09.00 s.d Selesai
							Ruangan : Aula 
							Terima Kasih atas partisipasinya.',
			'author'	=> 'Muhammad Firyanul Rizky',			
			'created_at'	=> '2024-01-12 16:00:00',
			'updated_at'	=> '2024-01-12 16:00:00',			
		],
		[
			'judul'	=> 'Rapat Audit Keuangan',
			'deskripsi'	=> 'Diumumkan kepada Seluruh Trainee departemen Finance agar mengikuti acara Rapat Audit pada :
							Hari : Rabu
							Pukul : 09.00 s.d Selesai
							Ruangan : Aula 
							Terima Kasih atas partisipasinya.',
			'author'	=> 'Muhammad Firyanul Rizky',			
			'created_at'	=> '2024-01-12 16:00:00',
			'updated_at'	=> '2024-01-12 16:00:00',			
		]	
		];
		DB::table('pengumumans')->insert($pengumumans);
    }
}
