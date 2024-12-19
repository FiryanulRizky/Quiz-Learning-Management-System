<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
	protected $table = 'moduls';
    protected $primaryKey = 'id_modul';  
    // protected $fillable = array('nama_modul', 'nik_trainer'); 
}
