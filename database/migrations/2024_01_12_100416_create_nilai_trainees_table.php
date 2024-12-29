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
            $table->integer('id_nilai_quiz_trainee')->unsigned();
            $table->foreign('id_nilai_quiz_trainee')->references('id_nilai_quiz_trainee')->on('nilai_quiz_trainees')->onDelete('cascade');                        
            
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
