<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraineeJawabUjianPilihanGandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainee_jawab_ujian_pilgans', function (Blueprint $table) {
            $table->increments('id_trainee_jawab_ujian_pilgan');
            $table->timestamps();
            //foreign key
            $table->integer('id_soal')->unsigned();
            $table->foreign('id_soal')->references('id_soal')->on('soals')->onDelete('cascade');
            // id_jawaban_soal_ujian harus boleh kosong, diperlukan pada sat proses pertama insert ke tabel trainee_jawabpilihan_gandas
            // $table->integer('id_jawaban_soal_ujian')->unsigned()->nullable()->change();
            $table->integer('id_jawaban_soal_ujian')->unsigned()->nullable();
            $table->foreign('id_jawaban_soal_ujian')->references('id_jawaban_soal_ujian')->on('jawaban_soal_ujians')->onDelete('cascade');
            $table->integer('id_nilai_ujian_pilgan')->unsigned();
            $table->foreign('id_nilai_ujian_pilgan')->references('id_nilai_ujian_pilgan')->on('nilai_ujian_pilgan_trainees')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trainee_jawab_ujian_pilgans');
    }
}
