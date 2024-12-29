<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizs', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('jenis_quiz'); 
            $table->string('judul_quiz'); // nama quiz
            $table->string('info_quiz');  // keterangan
            $table->string('departemen_quiz');                       
            $table->string('waktu_quiz'); // batas waktu
            $table->tinyInteger('jumlah_soal');  
            $table->enum('is_random', ['1', '0'])->default('0');
            $table->string('pembuat_quiz');
            $table->date('tgl_quiz');            
            $table->string('status_quiz');            
            $table->timestamps();
            // foreign key                        
            $table->integer('id_modul')->unsigned();
            $table->foreign('id_modul')->references('id_modul')->on('moduls')->onDelete('cascade');               
            // $table->integer('id_user')->unsigned();
            // $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizs');
    }
}
