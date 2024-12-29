<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->increments('id_soal');
            $table->string('jenis_soal');            
            $table->string('pertanyaan');
            $table->string('gambar');            
            $table->timestamps();
            // foreign key            
            $table->integer('id_quiz')->unsigned();
            $table->foreign('id_quiz')->references('id_quiz')->on('quizs')->onDelete('cascade');            
                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soals');
    }
}
