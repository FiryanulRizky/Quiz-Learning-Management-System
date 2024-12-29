<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoalHasQuiz extends Model
{
    protected $table = 'soal_has_quizs';

    public function soal()
    {
        return $this->belongsTo(\App\Soal::class, 'soals');
    }


    // public function quiz()
    // {
    //     return $this->belongsTo('quizs', 'id_quiz');
    // }

    public function quiz()
    {
        return $this->belongsTo(\App\Quiz::class, 'quizs');
    }
}
