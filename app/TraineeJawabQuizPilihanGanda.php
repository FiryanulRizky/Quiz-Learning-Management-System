<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraineeJawabQuizPilihanGanda extends Model
{
    protected $table = 'trainee_jawab_quiz_pilgans';
    protected $primaryKey = 'id_trainee_jawab_quiz_pilgan';

    public function soal()
    {
        return $this->belongsTo('soals', 'id_soal');
    }

    public function userjawabPilihanGanda()
    {
        return $this->hasMany('TraineeJawabQuizPilihanGanda');
        // return $this->hasOne('UserJawab');
    }

    public function quiz()
    {
        return $this->belongsTo('quizs', 'id_quiz');
    }

    public function user()
    {
        return $this->belongsTo('users', 'id_user');
    }

    public function jawaban()
    {
        return $this->belongsTo(\App\JawabanSoalQuiz::class, 'jawaban_soal_quizs', 'id_soal');
    }

    public function user_jawab_quiz()
    {
        return $this->belongsTo('quizs', 'id_jawaban_soal_quiz');
    }
}
