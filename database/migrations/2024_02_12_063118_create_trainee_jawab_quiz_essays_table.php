<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraineeJawabQuizEssaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainee_jawab_quiz_essays', function (Blueprint $table) {
            $table->increments('id_trainee_jawab_quiz_essays');
            $table->timestamps();
            // foreign key
            $table->integer('id_soal')->unsigned();
            $table->foreign('id_soal')->references('id_soal')->on('soals')->onDelete('cascade');
            $table->integer('id_jawaban_soal_quiz')->unsigned();
            $table->foreign('id_jawaban_soal_quiz')->references('id_jawaban_soal_quiz')->on('jawaban_soal_quizs')->onDelete('cascade');
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
        Schema::drop('trainee_jawab_quiz_essays');
    }
}
