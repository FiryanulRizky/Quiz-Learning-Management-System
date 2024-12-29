<?php

use Illuminate\Database\Seeder;

class SoalQuizTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $soals = [
        [ 
			'jenis_soal'		=> 'Pilihan Ganda',
			'pertanyaan'		=> '<p>Paket Pekerjaan yang terdiri atas banyak service disebut ?</p>',			
			'gambar'		=> '',
			'id_quiz'		=> '1',			
		],
		[ 
			'jenis_soal'		=> 'Pilihan Ganda',
			'pertanyaan'		=> '<p>Raihan memerlukan Layanan Jual <strong><em>LCL</em></strong> pada pengiriman Logistik nya. Jelaskan cara memilih layanan jual LCL pada Job File yang dibuat!</p>',			
			'gambar'		=> '',
			'id_quiz'		=> '1',
		] 	
		];    

		DB::table('soals')->insert($soals);
    }
}
