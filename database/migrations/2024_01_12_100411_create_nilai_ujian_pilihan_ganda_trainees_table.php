<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiUjianPilihanGandaTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_ujian_pilgan_trainees', function (Blueprint $table) {
            $table->increments('id_nilai_ujian_pilgan');            
            $table->integer('nilai');
            $table->timestamps();
            // $table->timestamp('wkt_mulai')->nullable()->change();
            // $table->timestamp('wkt_selesai')->nullable()->change();
            $table->timestamp('wkt_mulai')->nullable();
            $table->timestamp('wkt_selesai')->nullable();
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
        Schema::drop('nilai_ujian_pilgan_trainees');
    }
}
