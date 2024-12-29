<?php

use Illuminate\Database\Seeder;

class NilaiQuizTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nilai_quiz = [
        [ 
			'nik_trainee'	=> '121',						
			'nilai_quiz'	=> '100',		
			'created_at'	=> '2024-02-12 16:00:00',
			'updated_at'	=> '2024-02-12 16:00:00',			
		],
		[ 
			'nik_trainee'	=> '122',					
			'nilai_quiz'	=> '90',		
			'created_at'	=> '2024-02-12 16:00:00',
			'updated_at'	=> '2024-02-12 16:00:00',			
		] 	
		];    

		DB::table('nilai_quiz_trainees')->insert($nilai_quiz);
    }
}
