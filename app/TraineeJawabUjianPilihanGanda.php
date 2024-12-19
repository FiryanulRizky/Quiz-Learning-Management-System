<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraineeJawabUjianPilihanGanda extends Model
{
    protected $table = 'trainee_jawab_ujian_pilgans';
    protected $primaryKey = 'id_trainee_jawab_ujian_pilgan';

    public function soal()
    {
        return $this->belongsTo('soals', 'id_soal');
    }

    public function userjawabPilihanGanda()
    {
        return $this->hasMany('TraineeJawabUjianPilihanGanda');
        // return $this->hasOne('UserJawab');
    }

    public function ujian()
    {
        return $this->belongsTo('ujians', 'id_ujian');
    }

    public function user()
    {
        return $this->belongsTo('users', 'id_user');
    }

    public function jawaban()
    {
        return $this->belongsTo(\App\JawabanSoalUjian::class, 'jawaban_soal_ujians', 'id_soal');
    }

    public function user_jawab_ujian()
    {
        return $this->belongsTo('ujians', 'id_jawaban_soal_ujian');
    }
}
