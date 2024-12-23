<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTugassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugass', function (Blueprint $table) {
            $table->increments('id_tugas');
            $table->string('judul_tugas');
            $table->string('deskripsi_tugas');
            $table->string('departemen_tugas');                    
            $table->string('waktu_tugas');
            $table->string('pembuat_tugas');
            $table->date('tgl_tugas');
            $table->string('info_tugas');
            $table->string('status_tugas');
            $table->string('sms_status_tugas');                
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
        Schema::dropIfExists('tugass');
    }
}
