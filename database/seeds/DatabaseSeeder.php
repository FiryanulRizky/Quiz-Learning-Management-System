<?php

use App\MateriModul;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
		$this->call(UsersTableSeeder::class);
        $this->call(TrainersTableSeeder::class);
        $this->call(ModulTableSeeder::class);
        $this->call(PengumumansTableSeeder::class);
        $this->call(TraineesTableSeeder::class);
        $this->call(TugasTableSeeder::class);
        $this->call(QuizTableSeeder::class);
        $this->call(SoalQuizTableSeeder::class);
        $this->call(JawabanSoalTableSeeder::class);
        $this->call(MateriModulTableSeeder::class);

        // $this->call(NilaiTugasTableSeeder::class);
        // $this->call(NilaiQuizTableSeeder::class);
        // $this->call(NilaiTableSeeder::class);
        

		
    }
}
