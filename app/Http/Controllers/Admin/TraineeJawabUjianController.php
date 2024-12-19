<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TraineeJawabUjianPilihanGanda as TraineeJawabUjianPilihanGanda;
use App\NilaiUjianPilihanGandaTrainee as NilaiUjianPilihanGandaTrainee;

class TraineeJawabUjianController extends Controller
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
            $nilaiUjianPilganTrainee = NilaiUjianPilihanGandaTrainee::whereRaw('id_ujian = ? and wkt_selesai is not null', array($id))
                ->orderBy('nilai', 'desc')
                ->orderBy('int_time', 'asc')->get(
                    array(DB::raw("TIMEDIFF(wkt_selesai, wkt_mulai) as 'int_time'"),
                        DB::raw('nilai_ujian_pilgan_trainees.*')
                    ));

            // $ujian = Ujian::find($id_ujian);
            $ujian = DB::table('ujians')                  
                 ->join('moduls', 'ujians.id_modul', '=', 'moduls.id_modul')
                 ->select('ujians.*', 'moduls.nama_modul')
                 ->where('ujians.id_ujian', $id)
                 ->first();

            if (!$ujian)
                throw new Exception('Detail Ujian dengan kode ' . $id_ujian . ' tidak ditemukan');

            if (!$nilaiUjianPilganTrainee->isEmpty()) {
                foreach ($nilaiUjianPilganTrainee as $ujb) {
                    $start_date    = new \DateTime($ujb->wkt_mulai);
                    $since_start   = $start_date->diff(new \DateTime($ujb->wkt_selesai));
                    $ujb->interval = $since_start->h . ' jam ' . $since_start->i . ' menit ' . $since_start->s . ' detik';
                }
            }else {
                if (Auth::user()->level == 11 or Auth::user()->level == 12) {
                    Session::flash('flash_message', 'Belum ada trainee yang mengambil ujian ini');
                    return Redirect::back(); 
                }
                Session::flash('flash_message', 'Anda belum pernah mengambil ujian ini, Silahkan Klik Tombol "Mulai mengerjakan Ujian" untuk mengambil ujian ini');
                return Redirect::back(); 
            }

            return view('admin.dashboard.trainee_jawab_ujian.show_peringkat_trainee')
                ->with('userJawabLembars', $nilaiUjianPilganTrainee)
                ->with('ujian', $ujian);

        } catch (Exception $e) {
            Log::error($e);
            return Redirect::action('Admin\UjianController@index_trainee')->with('messages',
                array(
                    array('error', $e->getMessage())
                ));

        }
    }    
}
