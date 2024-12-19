<?php

use Illuminate\Database\Seeder;

class TugasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tugas = [
        [ 
			'judul_tugas'		=> 'Tugas Membuat Breakdown Job File',
			'deskripsi_tugas'	=> 'Input Job File berdasarkan studi kasus yang diberikan',			
			'departemen_tugas'		=> 'Operasional',
			'waktu_tugas'		=> '1 Hari',
			'pembuat_tugas'		=> 'Muhammad Firyanul Rizky',
			'tgl_tugas'			=> '2024-12-18',
			'info_tugas'		=> 'Paling Lambat Upload Tugas hari ini',
			'status_tugas'		=> 'Aktif',
			'sms_status_tugas'	=> 'Aktif',
			'id_modul'			=> '3',
			'created_at'		=> '2018-02-01 16:00:00',
			'updated_at'		=> '2018-02-01 16:00:00',			
		] 	
		];    

		DB::table('tugass')->insert($tugas);
    }
}
