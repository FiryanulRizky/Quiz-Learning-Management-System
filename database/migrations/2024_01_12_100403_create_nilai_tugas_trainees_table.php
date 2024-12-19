<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiTugasTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_tugas_trainees', function (Blueprint $table) {
            $table->increments('id_nilai_tugas_trainee');
            $table->string('nilai_tugas');
            $table->timestamps();
            $table->timestamp('wkt_mulai');
            $table->timestamp('wkt_selesai');

            // foreign key  
            $table->integer('id_tugas')->unsigned();
            $table->foreign('id_tugas')->references('id_tugas')->on('tugass')->onDelete('cascade');           
            $table->string('nik_trainee');
            $table->foreign('nik_trainee')->references('nik_trainee')->on('trainees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nilai_tugas_trainees');
    }
}
