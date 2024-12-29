<?php

use Illuminate\Database\Seeder;

class QuizTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quiz = [
        [ 
			'jenis_quiz'		=> 'Quiz Latihan',
			'judul_quiz'		=> 'Job File Manajemen',			
			'departemen_quiz'		=> 'Operasional',
			'waktu_quiz'		=> '60',
			'jumlah_soal'		=> '20',
			'is_random'			=> '0',
			'pembuat_quiz'		=> 'Muhammad Firyanul Rizky',
			'tgl_quiz'			=> '2024-12-18',
			'info_quiz'		=> 'Dikerjakan Sekarang Juga',
			'status_quiz'		=> 'Aktif',						
			'created_at'		=> '2024-03-12 16:00:00',
			'updated_at'		=> '2024-03-12 16:00:00',		
			'id_modul'			=> '3',
		],
		[ 
			'jenis_quiz'		=> 'Quiz Uji Kompetensi',
			'judul_quiz'		=> 'Quotation Request',			
			'departemen_quiz'		=> 'Marketing',
			'waktu_quiz'		=> '120',
			'jumlah_soal'		=> '20',
			'is_random'			=> '1',
			'pembuat_quiz'		=> 'Muhammad Firyanul Rizky',
			'tgl_quiz'			=> '2024-12-18',
			'info_quiz'		=> 'Dikerjakan Sekarang Juga',
			'status_quiz'		=> 'Aktif',						
			'created_at'		=> '2024-03-12 16:00:00',
			'updated_at'		=> '2024-03-12 16:00:00',		
			'id_modul'			=> '3',
		] 	
		];    

		DB::table('quizs')->insert($quiz);
    }
}
