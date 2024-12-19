<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Soal as Soal;
use App\JawabanSoalUjian as JawabanSoalUjian;
use App\TraineeJawabUjianPilihanGanda as TraineeJawabUjianPilihanGanda;
use App\NilaiUjianPilihanGandaTrainee as NilaiUjianPilihanGandaTrainee;

class NilaiUjianPilihanGandaTrainee extends Model
{
    protected $table = 'nilai_ujian_pilgan_trainees';
    protected $primaryKey = 'id_nilai_ujian_pilgan';

    // SUDAH DI CEK 
    public function calcScore()
    {
        $jawabanBenar  = 0;
        $jawabanSalah  = 0;
        $jawabanKosong = 0;

        foreach (TraineeJawabUjianPilihanGanda::whereRaw('id_nilai_ujian_pilgan = ? ', array($this->id_nilai_ujian_pilgan))->get() as $traineeJawab) {

            $nilaiUjian = NilaiUjianPilihanGandaTrainee::find($traineeJawab->id_nilai_ujian_pilgan);            
            $ujian = Ujian::find($nilaiUjian->id_ujian);            
            $jumlahsoal   = Soal::where('jenis_soal', '=', 'Pilihan Ganda')->where('id_ujian', '=', $nilaiUjian->id_ujian)->count();  // jumlah soal pilihan ganda yang tersedia
            $waktu_ujian = $ujian->waktu_ujian;
            
            if (!$traineeJawab->id_jawaban_soal_ujian)
                $jawabanKosong++;
            else {
                //get jawaban benar of soal
                $jawabanBenars = JawabanSoalUjian::where('id_soal', $traineeJawab->id_soal)->get()->filter(function ($jawaban) {                
                    if ($jawaban->is_benar) {
                        return $jawaban;
                    }
                });

                $isBenar = false;
                foreach ($jawabanBenars as $jawabanBenarFromSoal) {
                    if ($traineeJawab->id_jawaban_soal_ujian == $jawabanBenarFromSoal->id_jawaban_soal_ujian) {
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

        // $this->nilai = (4 * $jawabanBenar) - (2 * $jawabanSalah) - $jawabanKosong + (int)$waktu_ujian; // bawaan dari aplikasi awal
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
