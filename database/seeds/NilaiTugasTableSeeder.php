<?php

use Illuminate\Database\Seeder;

class NilaiTugasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nilai_tugas = [
        [ 
			'nik_trainee'	=> '121',
			'id_tugas'		=> '1',			
			'id_modul'		=> '1',			
			'nilai_tugas'	=> '80',		
			'created_at'	=> '2024-02-12 16:00:00',
			'updated_at'	=> '2024-02-12 16:00:00',			
		],
		[ 
			'nik_trainee'	=> '122',
			'id_tugas'		=> '1',			
			'id_modul'		=> '1',			
			'nilai_tugas'	=> '99',		
			'created_at'	=> '2024-02-12 16:00:00',
			'updated_at'	=> '2024-02-12 16:00:00',			
		] 	
		];    

		DB::table('nilai_tugas_trainees')->insert($nilai_tugas);
    }
}
