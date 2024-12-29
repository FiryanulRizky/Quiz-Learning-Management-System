<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiTrainee extends Model
{
	protected $table = 'nilai_trainees';
    protected $primaryKey = 'id_nilai_trainee';
    // protected $fillable = {
    // 	'jenis_nilai','id_tugas','id_quiz','id_modul','nik_trainee'
    // }
}
