<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_trainees', function (Blueprint $table) {
            $table->increments('id_nilai_trainee');            
            $table->timestamps();

            // foreign key            
            $table->string('nik_trainee');
            $table->foreign('nik_trainee')->references('nik_trainee')->on('trainees')->onDelete('cascade');
            $table->integer('id_nilai_tugas_trainee')->unsigned();
            $table->foreign('id_nilai_tugas_trainee')->references('id_nilai_tugas_trainee')->on('nilai_tugas_trainees')->onDelete('cascade');                        
            $table->integer('id_nilai_ujian_trainee')->unsigned();
            $table->foreign('id_nilai_ujian_trainee')->references('id_nilai_ujian_trainee')->on('nilai_ujian_trainees')->onDelete('cascade');                        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_trainees');
    }
}
