<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainers', function (Blueprint $table) {            
            $table->string('nik_trainer');
            $table->string('nama_trainer');
            $table->text('ttl_trainer');
            $table->string('jns_kelamin_trainer');
            $table->string('agama_trainer');
            $table->string('no_telp_trainer');
            $table->string('email_trainer');
            $table->string('alamat_trainer');
            $table->string('jabatan_trainer');
            $table->string('foto_trainer');
            $table->string('status_trainer');
            $table->timestamps(); 
            // foreign key
            $table->integer('id_user')->unsigned();
            // $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');   
            $table->primary('nik_trainer');               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainers');
    }
}
