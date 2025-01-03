<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_gateways', function (Blueprint $table) {
            $table->increments('id_sms_gateway');
            $table->string('pesan');            
            $table->string('no_hp'); 
            $table->timestamps();
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
        Schema::dropIfExists('sms_gateways');
    }
}
