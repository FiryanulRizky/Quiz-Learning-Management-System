<?php

use Illuminate\Database\Seeder;

class NilaiUjianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nilai_ujian = [
        [ 
			'nik_trainee'	=> '121',						
			'nilai_ujian'	=> '100',		
			'created_at'	=> '2024-02-12 16:00:00',
			'updated_at'	=> '2024-02-12 16:00:00',			
		],
		[ 
			'nik_trainee'	=> '122',					
			'nilai_ujian'	=> '90',		
			'created_at'	=> '2024-02-12 16:00:00',
			'updated_at'	=> '2024-02-12 16:00:00',			
		] 	
		];    

		DB::table('nilai_ujian_trainees')->insert($nilai_ujian);
    }
}
