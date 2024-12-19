<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiUjianTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_ujian_trainees', function (Blueprint $table) {
            $table->increments('id_nilai_ujian_trainee');
            $table->string('nilai_ujian');
            $table->timestamps();

            // foreign key  
            $table->string('nik_trainee');
            $table->foreign('nik_trainee')->references('nik_trainee')->on('trainees')->onDelete('cascade');
            $table->integer('id_nilai_tugas_trainee')->unsigned();
            $table->integer('id_nilai_ujian_pilgan')->unsigned();
            $table->foreign('id_nilai_ujian_pilgan')->references('id_nilai_ujian_pilgan')->on('nilai_ujian_pilgan_trainees')->onDelete('cascade');
            $table->integer('id_nilai_ujian_essay')->unsigned();
            $table->foreign('id_nilai_ujian_essay')->references('id_nilai_ujian_essay')->on('nilai_ujian_essay_trainees')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nilai_ujian_trainees');
    }
}
