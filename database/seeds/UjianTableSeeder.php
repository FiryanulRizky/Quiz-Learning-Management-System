<?php

use Illuminate\Database\Seeder;

class UjianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ujian = [
        [ 
			'jenis_ujian'		=> 'Ujian Harian',
			'judul_ujian'		=> 'Job File Manajemen',			
			'departemen_ujian'		=> 'Operasional',
			'waktu_ujian'		=> '60',
			'jumlah_soal'		=> '20',
			'is_random'			=> '0',
			'pembuat_ujian'		=> 'Muhammad Firyanul Rizky',
			'tgl_ujian'			=> '2024-12-18',
			'info_ujian'		=> 'Dikerjakan Sekarang Juga',
			'status_ujian'		=> 'Aktif',						
			'created_at'		=> '2018-03-03 16:00:00',
			'updated_at'		=> '2018-03-03 16:00:00',		
			'id_modul'			=> '3',
		],
		[ 
			'jenis_ujian'		=> 'Ujian MID',
			'judul_ujian'		=> 'Quotation Request',			
			'departemen_ujian'		=> 'Marketing',
			'waktu_ujian'		=> '120',
			'jumlah_soal'		=> '20',
			'is_random'			=> '1',
			'pembuat_ujian'		=> 'Muhammad Firyanul Rizky',
			'tgl_ujian'			=> '2024-12-18',
			'info_ujian'		=> 'Dikerjakan Sekarang Juga',
			'status_ujian'		=> 'Aktif',						
			'created_at'		=> '2018-03-03 16:00:00',
			'updated_at'		=> '2018-03-03 16:00:00',		
			'id_modul'			=> '3',
		] 	
		];    

		DB::table('ujians')->insert($ujian);
    }
}
