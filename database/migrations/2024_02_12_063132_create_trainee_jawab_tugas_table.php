<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraineeJawabTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainee_jawab_tugas', function (Blueprint $table) {
            $table->increments('id_trainee_jawab_tugas');
            $table->text('jawaban_tugas');
            $table->string('nama_file_jawaban_tugas');
            $table->timestamps();
            // foreign key  
            $table->integer('id_tugas')->unsigned();
            $table->foreign('id_tugas')->references('id_tugas')->on('tugass')->onDelete('cascade');
            $table->string('nik_trainee');
            $table->foreign('nik_trainee')->references('nik_trainee')->on('trainees')->onDelete('cascade');
            $table->integer('id_nilai_tugas_trainee')->unsigned();
            $table->foreign('id_nilai_tugas_trainee')->references('id_nilai_tugas_trainee')->on('nilai_tugas_trainees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trainee_jawab_tugas');
    }
}
