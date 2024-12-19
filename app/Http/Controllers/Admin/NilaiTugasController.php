<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use DB;

use Validator;
use App\Http\Controllers\Controller;
use App\NilaiTugasTrainee as NilaiTugas;
use App\Modul as Modul_learn;
use App\Tugas as Tugas;
use App\Trainee as Trainee;
use Session;

class NilaiTugasController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function showTambahNilaiTugas()
  {
  	$idTrainee= Trainee::select(DB::raw("nik_trainee, nama_trainee"))
        ->orderBy(DB::raw("nik_trainee"))        
        ->get();
    $idModul_learn= Modul_learn::select(DB::raw("id_modul,nama_modul"))
        ->orderBy(DB::raw("id_modul"))        
        ->get();
    $idTugas= Tugas::select(DB::raw("id_tugas,judul_tugas"))
        ->orderBy(DB::raw("id_tugas"))        
        ->get();

    return view('admin.dashboard.nilai_tugas.tambah_nilai_tugas')
		->with('Trainee', $idTrainee)
        ->with('Modul_learn', $idModul_learn)
        ->with('Tugas', $idTugas);
  }

  public function index()
  {               
    $dataNilaiTugas = DB::table('nilai_tugas_trainees')   
     ->join('tugass', 'nilai_tugas_trainees.id_tugas', '=', 'tugass.id_tugas')                                   			       
     ->join('moduls', 'nilai_tugas_trainees.id_modul', '=', 'moduls.id_modul')
     ->join('trainees', 'nilai_tugas_trainees.nik_trainee', '=', 'trainees.nik_trainee')
     ->select('nilai_tugas_trainees.*', 'trainees.nama_trainee', 'moduls.nama_modul', 'tugass.judul_tugas')
     ->get();
        
    $data = array('nilai_tugas' => $dataNilaiTugas);   
     // dd($data);
    return view('admin.dashboard.nilai_tugas.nilai_tugas',$data);
  }    

 public function hapus($id_nilai_tugas_trainee )
  { 
  
    $id_nilai_tugas_trainee  = NilaiTugas::where('id_nilai_tugas_trainee ', '=', $id_nilai_tugas_trainee )->first();

    if ($id_nilai_tugas_trainee  == null)
      app::abort(404);
    
    Session::flash('flash_message', 'Data Nilai Tugas : "'.$id_nilai_tugas_trainee ->nik_trainee.'" Berhasil dihapus.');

    $id_nilai_tugas_trainee ->delete();
    
    return Redirect::action('Admin\NilaiTugasController@index');

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
          	'nik_trainee.required' 	=> 'NISN Trainee dibutuhkan.',
            'id_modul.required' 	=> 'ID Modul dibutuhkan.',            
            'id_tugas.required' 	=> 'ID Tugas dibutuhkan.',                              
            'nilai_tugas.required' 	=> 'Nilai Tugas dibutuhkan.', 
                     
        );

        $aturan = array(
            'nik_trainee'  	=> 'required',
            'id_modul'  	=> 'required',            
            'id_tugas'  	=> 'required',            
            'nilai_tugas'  	=> 'required',                      
        );        

        $validator = Validator::make($input,$aturan, $pesan);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses

        $nilai_tugas = new NilaiTugas;
        $nilai_tugas->nik_trainee    = $request['nik_trainee'];
        $nilai_tugas->id_modul     	= $request['id_modul'];
        $nilai_tugas->id_tugas     	= $request['id_tugas'];
        $nilai_tugas->nilai_tugas   = $request['nilai_tugas'];
                                                    
        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $nilai_tugas->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data Nilai Tugas "'.$request['nik_trainee'].'" Berhasil disimpan.');

        return Redirect::action('Admin\NilaiTugasController@index');
  }  

 public function edit($id_nilai_tugas_trainee )
    {
        
        $data = NilaiTugas::find($id_nilai_tugas_trainee );
        $idTrainee= Trainee::select(DB::raw("nik_trainee, nama_trainee"))
            ->orderBy(DB::raw("nik_trainee"))        
            ->get();
        $idModul_learn= Modul_learn::select(DB::raw("id_modul,nama_modul"))
        ->orderBy(DB::raw("id_modul"))        
        ->get();
	    $idTugas= Tugas::select(DB::raw("id_tugas,judul_tugas"))
	        ->orderBy(DB::raw("id_tugas"))        
	        ->get();	    			
        
        return view('admin.dashboard.nilai_tugas.edit_nilai_tugas',$data)
                ->with('Trainee', $idTrainee)
		        ->with('Modul_learn', $idModul_learn)
		        ->with('Tugas', $idTugas);

    }

 public function simpanedit(Request $request, $id_nilai_tugas_trainee )
    {
        $input =$request->all();
        $messages = [
			'nik_trainee.required' 	=> 'NISN Trainee dibutuhkan.',
            'id_modul.required' 	=> 'ID Modul dibutuhkan.',            
            'id_tugas.required' 	=> 'ID Tugas dibutuhkan.',                              
            'nilai_tugas.required' 	=> 'Nilai Tugas dibutuhkan.',                                            
        ];        

        $validator = Validator::make($input, [
        	'nik_trainee'  	=> 'required',
            'id_modul'  	=> 'required',            
            'id_tugas'  	=> 'required',            
            'nilai_tugas'  	=> 'required',          
            
        ], $messages);
                     

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();          
        }
        # Bila validasi sukses
        $editNilai = NilaiTugas::find($id_nilai_tugas_trainee );
        $editNilai->nik_trainee     	= $input['nik_trainee'];
        $editNilai->id_modul     	= $input['id_modul'];
        $editNilai->id_tugas     	= $input['id_tugas'];                              
        $editNilai->nilai_tugas     = $input['nilai_tugas']; 

        if (! $editNilai->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Nilai : " '.$input['nik_trainee'].'" Berhasil diubah.');

        return Redirect::action('Admin\NilaiTugasController@index'); 
    }
}

