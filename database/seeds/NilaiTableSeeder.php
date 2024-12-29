<?php

use Illuminate\Database\Seeder;

class NilaiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nilai = [
        [ 
			'nik_trainee'			=> '13312232',
			'id_nilai_tugas_trainee'	=> '1',			
			'id_nilai_quiz_trainee'	=> '1',			
			'created_at'			=> '2024-02-12 16:00:00',
			'updated_at'			=> '2024-02-12 16:00:00',			
		],
		[ 
			'nik_trainee'			=> '13312233',
			'id_nilai_tugas_trainee'	=> '2',			
			'id_nilai_quiz_trainee'	=> '2',			
			'created_at'			=> '2024-02-12 16:00:00',
			'updated_at'			=> '2024-02-12 16:00:00',			
		] 	
		];    

		DB::table('nilai_trainees')->insert($nilai);
    }
}
