<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiUjianEssayTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_ujian_essay_trainees', function (Blueprint $table) {
            $table->increments('id_nilai_ujian_essay');            
            $table->integer('nilai');
            $table->timestamps();
            $table->timestamp('wkt_mulai');
            $table->timestamp('wkt_selesai');
            // foreign key                
            $table->string('nik_trainee');
            $table->foreign('nik_trainee')->references('nik_trainee')->on('trainees')->onDelete('cascade');      
            $table->integer('id_ujian')->unsigned();
            $table->foreign('id_ujian')->references('id_ujian')->on('ujians')->onDelete('cascade'); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nilai_ujian_essay_trainees');
    }
}
