<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainees', function (Blueprint $table) {            
            $table->string('nik_trainee');
            $table->string('nama_trainee');
            $table->string('email_trainee');
            $table->string('no_hp_trainee');
            $table->string('ttl_trainee');
            $table->string('jns_kelamin_trainee');   
            $table->text('alamat_trainee');
            $table->string('departemen_trainee');
            $table->string('foto_trainee');
            $table->string('status_trainee');            
            $table->timestamps();
            // foreign key
            $table->integer('id_user')->unsigned();
            // $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->primary('nik_trainee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainees');
    }
}
