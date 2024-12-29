<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiQuizTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_quiz_trainees', function (Blueprint $table) {
            $table->increments('id_nilai_quiz_trainee');
            $table->string('nilai_quiz');
            $table->timestamps();

            // foreign key  
            $table->string('nik_trainee');
            $table->foreign('nik_trainee')->references('nik_trainee')->on('trainees')->onDelete('cascade');
            $table->integer('id_nilai_tugas_trainee')->unsigned();
            $table->integer('id_nilai_quiz_pilgan')->unsigned();
            $table->foreign('id_nilai_quiz_pilgan')->references('id_nilai_quiz_pilgan')->on('nilai_quiz_pilgan_trainees')->onDelete('cascade');
            $table->integer('id_nilai_quiz_essay')->unsigned();
            $table->foreign('id_nilai_quiz_essay')->references('id_nilai_quiz_essay')->on('nilai_quiz_essay_trainees')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nilai_quiz_trainees');
    }
}
