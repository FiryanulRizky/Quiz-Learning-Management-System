<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Soal as Soal;
use App\JawabanSoalQuiz as JawabanSoalQuiz;
use App\TraineeJawabQuizPilihanGanda as TraineeJawabQuizPilihanGanda;
use App\NilaiQuizPilihanGandaTrainee as NilaiQuizPilihanGandaTrainee;

class NilaiQuizPilihanGandaTrainee extends Model
{
    protected $table = 'nilai_quiz_pilgan_trainees';
    protected $primaryKey = 'id_nilai_quiz_pilgan';

    // SUDAH DI CEK 
    public function calcScore()
    {
        $jawabanBenar  = 0;
        $jawabanSalah  = 0;
        $jawabanKosong = 0;

        foreach (TraineeJawabQuizPilihanGanda::whereRaw('id_nilai_quiz_pilgan = ? ', array($this->id_nilai_quiz_pilgan))->get() as $traineeJawab) {

            $nilaiQuiz = NilaiQuizPilihanGandaTrainee::find($traineeJawab->id_nilai_quiz_pilgan);            
            $quiz = Quiz::find($nilaiQuiz->id_quiz);            
            $jumlahsoal   = Soal::where('jenis_soal', '=', 'Pilihan Ganda')->where('id_quiz', '=', $nilaiQuiz->id_quiz)->count();  // jumlah soal pilihan ganda yang tersedia
            $waktu_quiz = $quiz->waktu_quiz;
            
            if (!$traineeJawab->id_jawaban_soal_quiz)
                $jawabanKosong++;
            else {
                //get jawaban benar of soal
                $jawabanBenars = JawabanSoalQuiz::where('id_soal', $traineeJawab->id_soal)->get()->filter(function ($jawaban) {                
                    if ($jawaban->is_benar) {
                        return $jawaban;
                    }
                });

                $isBenar = false;
                foreach ($jawabanBenars as $jawabanBenarFromSoal) {
                    if ($traineeJawab->id_jawaban_soal_quiz == $jawabanBenarFromSoal->id_jawaban_soal_quiz) {
                        $isBenar = true;
                    }
                }

                if ($isBenar)
                    $jawabanBenar++;
                else
                    $jawabanSalah++;
            }
        }

        /*
        *   jika tidak ada jawaban yang benar
        *   nilai otomatis 0
         */
        if($jawabanBenar == 0) {
            $this->nilai = 0;
        }

        // $this->nilai = (4 * $jawabanBenar) - (2 * $jawabanSalah) - $jawabanKosong + (int)$waktu_quiz; // bawaan dari aplikasi awal
        /*
        *   nilai = jumlah benar * 100 / jumlah soal
        *   
        *   ex: 20 * 100 / 40
        *   nilai = 50
        *   
         */
        else {
            $this->nilai = $jawabanBenar * 100 / $jumlahsoal;
        }
    }
}
