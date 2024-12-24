<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use DB;
use Auth;

use Validator;
use App\Http\Controllers\Controller;
use App\Tugas as Tugas;
use App\Trainee as Trainee;
use App\Trainer as Trainer;
use App\Modul as Modul;
use App\Departemen as Departemen;
use App\TraineeJawabTugas as TraineeJawabTugas;
use Session;

class TugasController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function showTambahTugas()
  {      
    if (Auth::user()->level == 11) {
     $Modul_learn= Modul::select(DB::raw("id_modul, nama_modul"))
        ->orderBy(DB::raw("id_modul"))        
        ->get();
    return view('admin.dashboard.tugas.tambah_tugas')
        ->with('Modul_learn', $Modul_learn);        
    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();   
      $dataDepartemen = DB::table('departemen_have_moduls')                  
                 ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                 ->select('departemen_have_moduls.*', 'moduls.nama_modul')
                 ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                 ->orderBy('departemen_have_moduls.nama_departemen', 'asc')->get();
      return view('admin.dashboard.tugas.tambah_tugas')
        ->with('dataModul_learn', $Modul_learnTrainer)
        ->with('dataDepartemen', $dataDepartemen);
    }
  }

  public function index()
  {           
    if (Auth::user()->level == 11) {
      $dataTugas = DB::table('tugass')                  
                 ->join('moduls', 'tugass.id_modul', '=', 'moduls.id_modul')
                 ->select('tugass.*', 'moduls.nama_modul')
                 ->get();              
    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
      $dataTugas = DB::table('tugass')                  
                 ->join('moduls', 'tugass.id_modul', '=', 'moduls.id_modul')
                 ->select('tugass.*', 'moduls.nama_modul')
                 ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                 ->get();      
    }    
    $data = array('tugas' => $dataTugas);       
    return view('admin.dashboard.tugas.tugas',$data);
  }     
     
  public function index_trainer()
  {           
    return $this->index();
  }

  public function ShowPesertaKoreksiTugas($id)
  {       
    $tugasDepartemen = Tugas::where('id_tugas', $id)->first()->departemen_tugas;    
    $TraineeJawabTugas = DB::table('trainee_jawab_tugas')
                        ->join('tugass', 'trainee_jawab_tugas.id_tugas', '=', 'tugass.id_tugas')
                        ->join('trainees', 'trainee_jawab_tugas.nik_trainee', '=', 'trainees.nik_trainee')
                        ->leftjoin('moduls', 'tugass.id_modul', '=', 'moduls.id_modul')
                        ->select('trainee_jawab_tugas.*','tugass.judul_tugas', 'tugass.departemen_tugas', 'moduls.nama_modul', 'moduls.nik_trainer', 'trainees.nama_trainee')
                        ->where('trainees.departemen_trainee', $tugasDepartemen)
                        ->get();    
    $data = array('TraineeJawabTugas' => $TraineeJawabTugas);       
    return view('admin.dashboard.tugas.peserta_koreksi_tugas',$data);
  }

  public function updateNilaiTugasTrainee(Request $request, $id)
    {
        $input =$request->all();  
        $messages = [
            'nilai.required'      => 'Masukkan Nilai Trainee.',                                                     
        ];        

        $validator = Validator::make($input, [
            'nilai'       => 'required',            
        ], $messages);
                     
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();          
        }
        # Bila validasi sukses
        $editTraineeJawabTugas            = TraineeJawabTugas::where('id_trainee_jawab_tugas',$id)->first();                
        $editTraineeJawabTugas->nilai     = $input['nilai'];
        if (! $editTraineeJawabTugas->save())
          App::abort(500);

        Session::flash('flash_message', 'Nilai Tugas Berhasil disimpan.');
        return Redirect::back();
    }

  public function hapus($id_tugas)
  { 
  
    $id_tugas = Tugas::where('id_tugas', '=', $id_tugas)->first();

    if ($id_tugas == null)
      app::abort(404);
    
    Session::flash('flash_message', 'Data Tugas "'.$id_tugas->judul_tugas.'" - "'.$id_tugas->info_tugas.'" Berhasil dihapus.');

    $id_tugas->delete();
    
    if (Auth::user()->level == 11) {
      return redirect('admin/tugas/');
    }elseif (Auth::user()->level == 12) {
      return redirect('trainer/tugas/');
    }

  }

 public function tambah(Request $request)
    {          
          $input =$request->all();          
          
          // revisi check waktu tugas
          $wkt_selesai  = $request['wkt_selesai'];
          $wkt_sekarang = Date('Y-m-d H:i:s');                    
          if ($wkt_sekarang > $wkt_selesai) {            
                Session::flash('flash_message', 'Batas akhir pengumpulan tugas harus lebih dari waktu sekarang !!!');
                return Redirect::back(); 
          }

          $tgl_tugas_before = $request['wkt_mulai'];          
          $tgl_tugas = date ("Y-m-d", strtotime($tgl_tugas_before));
          $pesan = array(
              'judul_tugas.required' 		=> 'Judul Tugas dibutuhkan.',
              'deskripsi_tugas.required' 	=> 'Deskripsi Tugas dibutuhkan.',
              'departemen_tugas.required' 		=> 'Departemen Tugas dibutuhkan.',             
              'waktu_tugas_range.required' 		=> 'Waktu Tugas dibutuhkan.',
              'pembuat_tugas.required' 	=> 'Pembuat Tugas dibutuhkan.', 
              'info_tugas.required' 		=> 'Info Tugas dibutuhkan.',
              'status_tugas.required' 	=> 'Status Tugas dibutuhkan.', 
              'sms_status_tugas.required' => 'Status SMS Pemberitahuan Tugas Ke Trainee dibutuhkan.',
              'id_modul.required' 		=> 'ID Modul dibutuhkan.',       
                       
          );

          $aturan = array(
              'judul_tugas'      	=> 'required',
              'deskripsi_tugas'  	=> 'required',
              'departemen_tugas'     	=> 'required',
              'waktu_tugas_range'       => 'required',
              'pembuat_tugas'     => 'required',
              'info_tugas'        => 'required',
              'status_tugas'  	=> 'required',
              'sms_status_tugas'  => 'required',
              'id_modul'          => 'required',                       
          );
          
          $validator = Validator::make($input,$aturan, $pesan);

          if($validator->fails()) {
              # Kembali kehalaman yang sama dengan pesan error
              return Redirect::back()->withErrors($validator)->withInput();
          }
          # Bila validasi sukses

          $tugas = new Tugas;
          $tugas->judul_tugas         = $request['judul_tugas'];
          $tugas->deskripsi_tugas     = $request['deskripsi_tugas'];
          $tugas->departemen_tugas         = $request['departemen_tugas'];
          $tugas->waktu_tugas         = $request['waktu_tugas_range'];
          $tugas->wkt_mulai           = $request['wkt_mulai'];
          $tugas->wkt_selesai         = $request['wkt_selesai'];
          $tugas->pembuat_tugas       = $request['pembuat_tugas'];
          $tugas->tgl_tugas           = $tgl_tugas;
          $tugas->info_tugas          = $request['info_tugas'];
          $tugas->status_tugas        = $request['status_tugas'];
          $tugas->sms_status_tugas    = $request['sms_status_tugas'];
          $tugas->id_modul            = $request['id_modul'];              
                      
          //melakukan save, jika gagal (return value false) lakukan harakiri
          //error kode 500 - internel server error
          if (! $tugas->save() )
            App::abort(500);

          Session::flash('flash_message', 'Data Tugas'.$request['judul_tugas'].'" Berhasil disimpan.');
          
          if (Auth::user()->level == 11) {
            return redirect('admin/tugas/');
          }elseif (Auth::user()->level == 12) {
            return redirect('trainer/tugas/');
          }
          
          // return Redirect::action('Admin\TugasController@index');
    }  

 public function edittugas($id_tugas)
    { 
      $data = Tugas::find($id_tugas);                
      if (Auth::user()->level == 11) {
       $Modul_learn= Modul::select(DB::raw("id_modul, nama_modul"))
          ->orderBy(DB::raw("id_modul"))        
          ->get();
      return view('admin.dashboard.tugas.edit_tugas',$data)
          ->with('Modul_learn', $Modul_learn);        
      }elseif (Auth::user()->level == 12) {
        $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
        $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();   
        $dataDepartemen = DB::table('departemen_have_moduls')                  
                   ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                   ->select('departemen_have_moduls.*', 'moduls.nama_modul')
                   ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                   ->orderBy('departemen_have_moduls.nama_departemen', 'asc')->get();
        return view('admin.dashboard.tugas.edit_tugas',$data)
          ->with('dataModul_learn', $Modul_learnTrainer)
          ->with('dataDepartemen', $dataDepartemen);
      }                 
    }
    

 public function simpanedit(Request $request, $id_tugas)
    {
        $input =$request->all();
        // $tgl_tugas_before = $input['wkt_mulai'];          
        // $tgl_tugas = date ("Y-m-d", strtotime($tgl_tugas_before));
        $messages = [
            'judul_tugas.required'      => 'Judul Tugas dibutuhkan.',
            'deskripsi_tugas.required'  => 'Deskripsi Tugas dibutuhkan.',
            'departemen_tugas.required'      => 'Departemen Tugas dibutuhkan.',             
            // 'waktu_tugas_range.required'    => 'Waktu Tugas dibutuhkan.',
            'pembuat_tugas.required'    => 'Pembuat Tugas dibutuhkan.',             
            'info_tugas.required'       => 'Info Tugas dibutuhkan.',
            'status_tugas.required'     => 'Status Tugas dibutuhkan.', 
            'sms_status_tugas.required' => 'Status SMS Pemberitahuan Tugas Ke Trainee dibutuhkan.',
            'id_modul.required'         => 'ID Modul dibutuhkan.',                                           
        ];        

        $validator = Validator::make($input, [
            'judul_tugas'       => 'required',
            'deskripsi_tugas'   => 'required',
            'departemen_tugas'       => 'required',
            // 'waktu_tugas_range' => 'required',
            'pembuat_tugas'     => 'required',
            'info_tugas'        => 'required',
            'status_tugas'      => 'required',
            'sms_status_tugas'  => 'required',
            'id_modul'          => 'required',            
            
        ], $messages);                    

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();          
        }
        # Bila validasi sukses
        $editTugas = Tugas::find($id_tugas);
        $editTugas->judul_tugas         = $input['judul_tugas'];
        $editTugas->deskripsi_tugas     = $input['deskripsi_tugas'];
        $editTugas->departemen_tugas         = $input['departemen_tugas'];
        // $editTugas->waktu_tugas          = $input['waktu_tugas_range'];
        // $editTugas->wkt_mulai           = $input['wkt_mulai'];
        // $editTugas->wkt_selesai         = $input['wkt_selesai'];
        $editTugas->pembuat_tugas       = $input['pembuat_tugas'];
        // $editTugas->tgl_tugas           = $tgl_tugas;
        $editTugas->info_tugas          = $input['info_tugas'];
        $editTugas->status_tugas        = $input['status_tugas'];
        $editTugas->sms_status_tugas    = $input['sms_status_tugas'];
        $editTugas->id_modul            = $input['id_modul'];  
        // dd($editTugas);
             
        if (! $editTugas->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Tugas  dengan Judul : " '.$input['judul_tugas'].'" Berhasil diubah.');

        if (Auth::user()->level == 11) {
          return redirect('admin/tugas/');
        }elseif (Auth::user()->level == 12) {
          return redirect('trainer/tugas/');
        }
        // return Redirect::action('Admin\TugasController@index'); 
    }


  public function index_trainee()
  {   
    $trainee = Trainee::where('id_user', Auth::user()->id_user)->first();
    $dataTugas = DB::table('tugass')
                 ->join('moduls', 'tugass.id_modul', '=', 'moduls.id_modul')
                 ->select('tugass.*', 'moduls.nama_modul')
                 ->where('tugass.departemen_tugas', $trainee->departemen_trainee)
                 ->get();
        
    $data = array('tugas' => $dataTugas);   
    // dd($data);
    return view('admin.dashboard.tugas.tugas',$data);
  }


  // Hak Akses sebagai Trainee
  /* method detail => ketika trainee klik "Kerjakan" pada salah satu daftar tugas dalam modul_learn, maka akan menampilkan form upload file tugasnya
  * $id => id_tugas dari tabel tugas
  * 
  * $trainee_jawab_tugas : nisn, id_tugas, id_nilai_tugas, nama_file, nilai
  */
  public function show_detail_tugas_trainee($id)
    {           
      // $tugas = Tugas::find($id);
      $trainee = Trainee::where('id_user', Auth::user()->id_user)->first();
      $tugas = DB::table('tugass')
                   ->join('moduls', 'tugass.id_modul', '=', 'moduls.id_modul')
                   ->select('tugass.*', 'moduls.nama_modul')
                   ->where('tugass.id_tugas', $id)
                   ->first();
      // dd($tugas->id_tugas);
      $trainee_jawab_tugas = TraineeJawabTugas::where('id_tugas', $id)->where('nik_trainee', $trainee->nik_trainee)->get();
      // dd($trainee_jawab_tugas);
      if(!empty($trainee_jawab_tugas)){ 
        // $trainee_jawab_tugas = TraineeJawabTugas::where('id_tugas', $id)->where('nik_trainee', $trainee->nik_trainee)->first();
        $trainee_jawab_tugas = $trainee_jawab_tugas;
      }else{
        // dd('dfsdfsdfs');
        $trainee_jawab_tugas = '';
      }
           
      // dd($trainee_jawab_tugas);
      return view('admin.dashboard.tugas.detail_tugas')
              ->with('tugas', $tugas)
              ->with('traineeTugas', $trainee_jawab_tugas);  
    }

  public function tambah_tugas_trainee(Request $request)
    {
      $tugas = Tugas::find($request['id_tugas']);
      // dd($tugas);
      $wkt_selesai         = $tugas->wkt_selesai;
      $wkt_sekarang = Date('Y-m-d H:i:s');          
      //check waktu tugas
      if ($wkt_sekarang > $wkt_selesai) {            
            Session::flash('flash_message', 'Waktu mengerjakan tugas sudah habis, Anda tidak bisa mengirimkan tugas lagi');
            return Redirect::back(); 
      }else {             
            $input =$request->all();      
            $pesan = array(
                'judul.required'    => 'Judul dibutuhkan.',
                'nama_file.required'    => 'File Tugas dibutuhkan.',                                                 
            );

            $aturan = array(
                'judul'       => 'required',
                'nama_file'   => 'required|max:10000',                                
            );
            
            $validator = Validator::make($input,$aturan, $pesan);

            if($validator->fails()) {
                # Kembali kehalaman yang sama dengan pesan error
                return Redirect::back()->withErrors($validator)->withInput();
            }
            # Bila validasi sukses

            $nama_file = $request->file('nama_file');
            // dd($nama_file);
            $nama_file_tugas = $nama_file->getClientOriginalName();
            $request->file('nama_file')->move('file_tugas_trainee', $nama_file_tugas);        

            $tugasTrainee = new TraineeJawabTugas;
            $tugasTrainee->judul        = $input['judul'];
            $tugasTrainee->nama_file    = $nama_file_tugas;
            $tugasTrainee->id_tugas     = $input['id_tugas'];
            $tugasTrainee->nik_trainee   = Trainee::where('id_user', Auth::user()->id_user)->first()->nik_trainee;
            $tugasTrainee->nilai        = 0;
            
            if (! $tugasTrainee->save() )
              App::abort(500);

            Session::flash('flash_message', 'File tugas kamu berhasil disimpan.');
            return redirect('trainee/tugas/'.$input['id_tugas'].'/detail_tugas_trainee');
            // return Redirect::action('Admin\TugasController@show_detail_tugas_trainee'); 
      }        
    }

  public function hapus_tugas_trainee($id)
    {    
      $id_trainee_jawab_tugas = TraineeJawabTugas::where('id_trainee_jawab_tugas', '=', $id)->first();
      $id_tugas = $id_trainee_jawab_tugas->id_tugas;
      if ($id_trainee_jawab_tugas == null)
        app::abort(404);
      
      Session::flash('flash_message', 'File tugas kamu berhasil dihapus.');
      
      $image_path = public_path().'/file_tugas_trainee/'.$id_trainee_jawab_tugas->nama_file; 
      
      $id_trainee_jawab_tugas->delete();    
      
      unlink($image_path);
      return redirect('trainee/tugas/'.$id_tugas.'/detail_tugas_trainee');    
    }

  public function download_tugas_trainee($id)
    {
      $data = TraineeJawabTugas::find($id); 
      $file = public_path()."/file_tugas_trainee/".$data->nama_file;  
      $headers = array('Content-Type: application/pdf','Content-Type: application/doc', 'Content-Type: application/docx');
      return Response::download($file, $data->nama_file,$headers);
    }
} // end code

