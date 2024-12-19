<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {		
        $users = [
		[ 
			'name'	=> 'Muhammad Firyanul Rizky',
			'username'	=> 'rizky',
			'email'	=> 'rizki@tcontinent.com',
			'password'	=> bcrypt('rahasia'),
			'remember_token'	=> '',
			'created_at'	=> '2024-19-12 16:00:00',
			'updated_at'	=> '2024-19-12 16:00:00',
			'level'	=> '11',
		],
		[
			'name'	=> 'Gusti Denata Bagus Narawangsa',
			'username'	=> 'gusti',
			'email'	=> 'gusti@tcontinent.com',
			'password'	=> bcrypt('rahasia'),
			'remember_token'	=> '',
			'created_at'	=> '2024-19-12 16:00:00',
			'updated_at'	=> '2024-19-12 16:00:00',
			'level'	=> '12',
		],
		[
			'name'	=> 'Ade Nasfudin',
			'username'	=> 'ade_bpn',
			'email'	=> 'ade@tcontinent.com',
			'password'	=> bcrypt('rahasia'),
			'remember_token'	=> '',
			'created_at'	=> '2024-19-12 16:00:00',
			'updated_at'	=> '2024-19-12 16:00:00',
			'level'	=> '12',
		],
		[
			'name'	=> 'Tri Joko Yani',
			'username'	=> 'tri_joko',
			'email'	=> 'tri@tcontinent.com',
			'password'	=> bcrypt('rahasia'),
			'remember_token'	=> '',
			'created_at'	=> '2024-19-12 16:00:00',
			'updated_at'	=> '2024-19-12 16:00:00',
			'level'	=> '12',
		],
		[
			'name'	=> 'Lilis Sugiarti',
			'username'	=> 'lilis',
			'email'	=> 'lilis@tcontinent.com',
			'password'	=> bcrypt('rahasia'),
			'remember_token'	=> '',
			'created_at'	=> '2024-19-12 16:00:00',
			'updated_at'	=> '2024-19-12 16:00:00',
			'level'	=> '12',
		],
		[
			'name'	=> 'Fredy Hutagalung',
			'username'	=> 'fredy',
			'email'	=> 'fredy@tcontinent.com',
			'password'	=> bcrypt('rahasia'),
			'remember_token'	=> '',
			'created_at'	=> '2024-19-12 16:00:00',
			'updated_at'	=> '2024-19-12 16:00:00',
			'level'	=> '12',
		],
		[
			'name'	=> 'Muhammad Raihan',
			'username'	=> 'raihan',
			'email'	=> 'raihan@tcontinent.com',
			'password'	=> bcrypt('rahasia'),
			'remember_token'	=> '',
			'created_at'	=> '2024-19-12 16:00:00',
			'updated_at'	=> '2024-19-12 16:00:00',
			'level'	=> '13',
		],
		[
			'name'	=> 'Abda Syakura Taqwadin',
			'username'	=> 'abda',
			'email'	=> 'abda@tcontinent.com',
			'password'	=> bcrypt('rahasia'),
			'remember_token'	=> '',
			'created_at'	=> '2024-19-12 16:00:00',
			'updated_at'	=> '2024-19-12 16:00:00',
			'level'	=> '13',
		]	
		];    

		DB::table('users')->insert($users);
    }
}
