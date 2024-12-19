<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriAjarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materi_ajars', function (Blueprint $table) {
            $table->increments('id_materi_ajar');            
            $table->string('materi_judul');
            $table->string('materi_nama'); 
            $table->string('materi_departemen');           
            $table->timestamps();
            // foreign key
            $table->integer('id_modul')->unsigned();
            $table->foreign('id_modul')->references('id_modul')->on('moduls')->onDelete('cascade');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materi_ajars');
    }
}
