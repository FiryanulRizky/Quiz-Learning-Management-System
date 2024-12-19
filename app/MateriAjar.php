<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriAjar extends Model
{
	protected $table = 'materi_ajars';
    protected $primaryKey = 'id_materi_ajar';

    // protected $fillable = {
    // 	'materi_judul','materi_nama','id_modul'
    // }

    // public function Modul_learns(){
    // 	return $this->hasMany('App\Modul');
    // }

    public function Modul_learn(){
		return $this->hasMany('App\Modul', 'foreign_key', 'id_modul');
	}
}
