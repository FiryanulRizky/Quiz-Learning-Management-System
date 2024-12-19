<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Session;
use Response;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\TraineeJawabTugas as NilaiTugas; // tabel nilai tugas trainee
use App\NilaiUjianPilihanGandaTrainee as NilaiUjian; 
use App\Modul as Modul;
use App\Tugas as Tugas;
use App\DepartemenHaveModul as Departemen;
use App\Ujian as Ujian;
use App\Trainee as Trainee;
use App\Trainer as Trainer;

class NilaiController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function showTambahNilai()
  {
  	$idTrainee= Trainee::select(DB::raw("nik_trainee, nama_trainee"))
        ->orderBy(DB::raw("nik_trainee"))        
        ->get();
    $idNilaiTugas= NilaiTugas::select(DB::raw("id_nilai_tugas_trainee,nik_trainee"))
        ->orderBy(DB::raw("id_nilai_tugas_trainee"))        
        ->get();
    $idNilaiUjian= NilaiUjian::select(DB::raw("id_nilai_ujian_trainee,nik_trainee"))
        ->orderBy(DB::raw("id_nilai_ujian_trainee"))        
        ->get();
    // dd($data);        
    return view('admin.dashboard.nilai.tambah_nilai')
    		->with('Trainee', $idTrainee)
        ->with('NilaiTugas', $idNilaiTugas)
        ->with('NilaiUjian', $idNilaiUjian);
  }

  public function index()
    {                
    if (Auth::user()->level == 11) {
      $dataNilai = DB::table('nilai_trainees')   
                 ->join('nilai_ujian_trainees', 'nilai_trainees.id_nilai_ujian_trainee', '=', 'nilai_ujian_trainees.id_nilai_ujian_trainee') 
                 ->leftjoin('moduls','nilai_ujian_trainees.id_modul','=','moduls.id_modul')                                                
                 ->join('nilai_tugas_trainees', 'nilai_trainees.id_nilai_tugas_trainee', '=', 'nilai_tugas_trainees.id_nilai_tugas_trainee')
                 ->join('trainees', 'nilai_trainees.nik_trainee', '=', 'trainees.nik_trainee')
                 ->select('nilai_trainees.*', 'trainees.nama_trainee', 'moduls.nama_modul', 'nilai_ujian_trainees.nilai_ujian', 'nilai_tugas_trainees.nilai_tugas')
                 ->get();              
    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();      
      $dataNilai = DB::table('nilai_trainees')   
                 ->join('nilai_ujian_trainees', 'nilai_trainees.id_nilai_ujian_trainee', '=', 'nilai_ujian_trainees.id_nilai_ujian_trainee') 
                 ->leftjoin('moduls','nilai_ujian_trainees.id_modul','=','moduls.id_modul')                                                
                 ->join('nilai_tugas_trainees', 'nilai_trainees.id_nilai_tugas_trainee', '=', 'nilai_tugas_trainees.id_nilai_tugas_trainee')
                 ->join('trainees', 'nilai_trainees.nik_trainee', '=', 'trainees.nik_trainee')
                 ->select('nilai_trainees.*', 'trainees.nama_trainee', 'moduls.nama_modul', 'nilai_ujian_trainees.nilai_ujian', 'nilai_tugas_trainees.nilai_tugas')
                 ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                 ->get();             
    }
        
    $data = array('nilai' => $dataNilai);   
     // dd($data);
    return view('admin.dashboard.nilai.nilai',$data);
    }    
  public function hapus($id_nilai_trainee)
    {   
      $id_nilai_trainee = Nilai::where('id_nilai_trainee', '=', $id_nilai_trainee)->first();
      if ($id_nilai_trainee == null)
        app::abort(404);    
      Session::flash('flash_message', 'Data Nilai "'.$id_nilai_trainee->nik_trainee.'" Berhasil dihapus.');
      $id_nilai_trainee->delete();    
      if (Auth::user()->level == 11) {
        return redirect('admin/nilai_trainee/');
      }elseif (Auth::user()->level == 12) {
        return redirect('trainer/nilai_trainee/');
      }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data | Request $request | Opsional | dipakai keduanya bisa juga
     * @return User
     */
  protected function tambah(Request $request)
    {
        $input =$request->all();
        $pesan = array(
          	'nik_trainee.required' 		      => 'NISN Trainee dibutuhkan.',
            'id_nilai_tugas_trainee.required' => 'ID Nilai Tugas dibutuhkan.',            
            'id_nilai_ujian_trainee.required' => 'ID Nilai Ujian dibutuhkan.',                                                  
        );

        $aturan = array(
            'nik_trainee'  		      => 'required',
            'id_nilai_tugas_trainee'  => 'required',            
            'id_nilai_ujian_trainee'  => 'required',                                  
        );        
        $validator = Validator::make($input,$aturan, $pesan);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $nilai = new Nilai;
        $nilai->nik_trainee     	= $request['nik_trainee'];
        $nilai->id_nilai_tugas_trainee     	= $request['id_nilai_tugas_trainee'];
        $nilai->id_nilai_ujian_trainee     	= $request['id_nilai_ujian_trainee'];                  
                    
        if (! $nilai->save() )
          App::abort(500);
        Session::flash('flash_message', 'Data Nilai "'.$request['nik_trainee'].'" Berhasil disimpan.');
        if (Auth::user()->level == 11) {
          return redirect('admin/nilai_trainee/');
        }elseif (Auth::user()->level == 12) {
          return redirect('trainer/nilai_trainee/');
        }
    }  

  // Admin melihat nilai trainee berdasarkan departemen
  public function showDepartemenNilai(Request $request) 
  {
    if (Auth::user()->level == 11) {
      $listDepartemen = array('Manajemen', 'Marketing', 'Operasional', 'Warehouse Inventory', 'Fleet Yard', 'Driver', 'Account Payable', 'Account Receivable', 'Billing', 'Finance Accounting', 'Asset Vehicle');
    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
      $listDepartemen = DB::table('departemen_have_moduls')                  
                 ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                 ->select('departemen_have_moduls.nama_departemen')
                 ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                 ->orderBy('departemen_have_moduls.id', 'asc')->get(); 

    }        
    if(!empty($departemen_terpilih = $request->get('departemen_terpilih'))){
      $departemen_terpilih = $request->get('departemen_terpilih');                  
    }else {
      $departemen_terpilih = '';        
    }

    $nilaiTugas = DB::table('trainee_jawab_tugas')   
           ->join('tugass', 'trainee_jawab_tugas.id_tugas', '=', 'tugass.id_tugas') 
           ->join('trainees', 'trainee_jawab_tugas.nik_trainee', '=', 'trainees.nik_trainee')
           ->leftjoin('moduls','tugass.id_modul','=','moduls.id_modul')
           ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
           ->select('trainee_jawab_tugas.*', 'trainees.nik_trainee','trainees.nama_trainee', 'moduls.nama_modul', 'tugass.*', 'trainers.nik_trainer','trainers.nama_trainer')
           ->where('tugass.departemen_tugas', $departemen_terpilih)
           ->get();
      $nilaiUjian = DB::table('nilai_ujian_pilgan_trainees')   
           ->join('ujians', 'nilai_ujian_pilgan_trainees.id_ujian', '=', 'ujians.id_ujian') 
           ->join('trainees', 'nilai_ujian_pilgan_trainees.nik_trainee', '=', 'trainees.nik_trainee')
           ->leftjoin('moduls','ujians.id_modul','=','moduls.id_modul')
           ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
           ->select('nilai_ujian_pilgan_trainees.*', 'trainees.nik_trainee','trainees.nama_trainee', 'moduls.nama_modul', 'ujians.*', 'trainers.nik_trainer','trainers.nama_trainer')
           ->where('ujians.departemen_ujian', $departemen_terpilih)
           ->get();
    return view('admin.dashboard.nilai.nilai') 
            ->with('listDepartemen', $listDepartemen)
            ->with('departemen_terpilih', $departemen_terpilih)
            ->with('nilaiTugas', $nilaiTugas)
            ->with('nilaiUjian', $nilaiUjian);

  }

  // Admin melihat nilai trainee berdasarkan departemen
  public function showTraineeDepartemenNilai(Request $request) 
  {
    $trainee = Trainee::where('id_user', Auth::user()->id_user)->first();
    $listModul_learn = Departemen::select(DB::raw("id, nama_departemen, moduls.id_modul, moduls.nama_modul, moduls.nik_trainer"))   
                  ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                  ->where('nama_departemen', $trainee->departemen_trainee)->get();

    // dd($trainee->departemen_trainee,$request->get('modul_learn_terpilih'));

    if(!empty($modul_learn_terpilih = $request->get('modul_learn_terpilih'))){
      $modul_learn_terpilih = $request->get('modul_learn_terpilih');  
          
      $nilaiTugas = DB::table('trainee_jawab_tugas')   
           ->join('tugass', 'trainee_jawab_tugas.id_tugas', '=', 'tugass.id_tugas') 
           ->join('trainees', 'trainee_jawab_tugas.nik_trainee', '=', 'trainees.nik_trainee')
           ->leftjoin('moduls','tugass.id_modul','=','moduls.id_modul')
           ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
           ->select('trainee_jawab_tugas.*', 'trainees.nik_trainee','trainees.nama_trainee', 'moduls.nama_modul', 'tugass.*', 'trainers.nik_trainer','trainers.nama_trainer')
           ->where('tugass.departemen_tugas', $trainee->departemen_trainee)
           ->where('moduls.nama_modul', $modul_learn_terpilih)
           ->where('trainee_jawab_tugas.nik_trainee', $trainee->nik_trainee)
           ->get();
      $nilaiUjian = DB::table('nilai_ujian_pilgan_trainees')   
           ->join('ujians', 'nilai_ujian_pilgan_trainees.id_ujian', '=', 'ujians.id_ujian') 
           ->join('trainees', 'nilai_ujian_pilgan_trainees.nik_trainee', '=', 'trainees.nik_trainee')
           ->leftjoin('moduls','ujians.id_modul','=','moduls.id_modul')
           ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
           ->select('nilai_ujian_pilgan_trainees.*', 'trainees.nik_trainee','trainees.nama_trainee', 'moduls.nama_modul', 'ujians.*', 'trainers.nik_trainer','trainers.nama_trainer')
           ->where('ujians.departemen_ujian', $trainee->departemen_trainee)
           ->where('moduls.nama_modul', $modul_learn_terpilih)
           ->where('nilai_ujian_pilgan_trainees.nik_trainee', $trainee->nik_trainee)  
           ->get();

    }else {
      $modul_learn_terpilih = '';  
      $nilaiTugas = DB::table('trainee_jawab_tugas')   
           ->join('tugass', 'trainee_jawab_tugas.id_tugas', '=', 'tugass.id_tugas') 
           ->join('trainees', 'trainee_jawab_tugas.nik_trainee', '=', 'trainees.nik_trainee')
           ->leftjoin('moduls','tugass.id_modul','=','moduls.id_modul')
           ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
           ->select('trainee_jawab_tugas.*', 'trainees.nik_trainee','trainees.nama_trainee', 'moduls.nama_modul', 'tugass.*', 'trainers.nik_trainer','trainers.nama_trainer')
           ->where('tugass.departemen_tugas', $trainee->departemen_trainee)
           ->where('moduls.nama_modul', $modul_learn_terpilih)
           ->where('trainee_jawab_tugas.nik_trainee', $trainee->nik_trainee)
           ->get();
      $nilaiUjian = DB::table('nilai_ujian_pilgan_trainees')   
           ->join('ujians', 'nilai_ujian_pilgan_trainees.id_ujian', '=', 'ujians.id_ujian') 
           ->join('trainees', 'nilai_ujian_pilgan_trainees.nik_trainee', '=', 'trainees.nik_trainee')
           ->leftjoin('moduls','ujians.id_modul','=','moduls.id_modul')
           ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
           ->select('nilai_ujian_pilgan_trainees.*', 'trainees.nik_trainee','trainees.nama_trainee', 'moduls.nama_modul', 'ujians.*', 'trainers.nik_trainer','trainers.nama_trainer')
           ->where('ujians.departemen_ujian', $trainee->departemen_trainee)
           ->where('moduls.nama_modul', $modul_learn_terpilih)
           ->where('nilai_ujian_pilgan_trainees.nik_trainee', $trainee->nik_trainee)
           ->get();
    }

    return view('admin.dashboard.nilai.detail_nilai_trainee') 
                ->with('trainee', $trainee)
                ->with('listModul_learn', $listModul_learn)
                ->with('modul_learn_terpilih', $modul_learn_terpilih)
                ->with('nilaiTugas', $nilaiTugas)
                ->with('nilaiUjian', $nilaiUjian);

  }
} 
