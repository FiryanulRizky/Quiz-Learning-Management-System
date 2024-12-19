<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{    
	protected $table = 'trainers';
    protected $primaryKey = 'nik_trainer';
    protected $fillable = [
    	'nik_trainer', 'nama_trainer', 'ttl_trainer','jns_kelamin_trainer','agama_trainer','no_telp_trainer','email_trainer','alamat_trainer','jabatan_trainer','foto_trainer','status_trainer'
    ];
    
}
