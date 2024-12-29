<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriModul extends Model
{
	protected $table = 'materi_moduls';
    protected $primaryKey = 'id_materi_modul';

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
