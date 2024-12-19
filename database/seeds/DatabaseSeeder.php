<?php

use App\MateriAjar;
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
        $this->call(UjianTableSeeder::class);
        $this->call(SoalUjianTableSeeder::class);
        $this->call(JawabanSoalTableSeeder::class);
        $this->call(MateriAjarTableSeeder::class);

        // $this->call(NilaiTugasTableSeeder::class);
        // $this->call(NilaiUjianTableSeeder::class);
        // $this->call(NilaiTableSeeder::class);
        

		
    }
}
