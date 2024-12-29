<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TraineeJawabQuizPilihanGanda as TraineeJawabQuizPilihanGanda;
use App\NilaiQuizPilihanGandaTrainee as NilaiQuizPilihanGandaTrainee;

class TraineeJawabQuizController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $nilaiQuizPilganTrainee = NilaiQuizPilihanGandaTrainee::whereRaw('id_quiz = ? and wkt_selesai is not null', array($id))
                ->orderBy('nilai', 'desc')
                ->orderBy('int_time', 'asc')->get(
                    array(DB::raw("TIMEDIFF(wkt_selesai, wkt_mulai) as 'int_time'"),
                        DB::raw('nilai_quiz_pilgan_trainees.*')
                    ));

            // $quiz = Quiz::find($id_quiz);
            $quiz = DB::table('quizs')                  
                 ->join('moduls', 'quizs.id_modul', '=', 'moduls.id_modul')
                 ->select('quizs.*', 'moduls.nama_modul')
                 ->where('quizs.id_quiz', $id)
                 ->first();

            if (!$quiz)
                throw new Exception('Detail Quiz dengan kode ' . $id_quiz . ' tidak ditemukan');

            if (!$nilaiQuizPilganTrainee->isEmpty()) {
                foreach ($nilaiQuizPilganTrainee as $ujb) {
                    $start_date    = new \DateTime($ujb->wkt_mulai);
                    $since_start   = $start_date->diff(new \DateTime($ujb->wkt_selesai));
                    $ujb->interval = $since_start->h . ' jam ' . $since_start->i . ' menit ' . $since_start->s . ' detik';
                }
            }else {
                if (Auth::user()->level == 11 or Auth::user()->level == 12) {
                    Session::flash('flash_message', 'Belum ada trainee yang mengambil quiz ini');
                    return Redirect::back(); 
                }
                Session::flash('flash_message', 'Anda belum pernah mengambil quiz ini, Silahkan Klik Tombol "Mulai mengerjakan Quiz" untuk mengambil quiz ini');
                return Redirect::back(); 
            }

            return view('admin.dashboard.trainee_jawab_quiz.show_peringkat_trainee')
                ->with('userJawabLembars', $nilaiQuizPilganTrainee)
                ->with('quiz', $quiz);

        } catch (Exception $e) {
            Log::error($e);
            return Redirect::action('Admin\QuizController@index_trainee')->with('messages',
                array(
                    array('error', $e->getMessage())
                ));

        }
    }    
}
