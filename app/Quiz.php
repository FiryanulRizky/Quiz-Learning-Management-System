<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
	protected $table = 'quizs';
    protected $primaryKey = 'id_quiz';

    public function trainee_jawab_pilgans()
    {
    	return $this->hasMany(Trainee::class);
    }

    public function soalhasquiz()
    {
        return $this->belongsToMany(\App\Soal::class, 'soal_has_quizs', 'id_soal', 'id_quiz');
        // return $this->hasMany(\App\Soal::class, 'soal_has_quizs', 'id_quiz', 'id_soal');
    }

    
}
