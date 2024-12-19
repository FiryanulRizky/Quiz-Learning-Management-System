<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use DB;

use Validator;
use App\Http\Controllers\Controller;
use App\NilaiUjianTrainee as NilaiUjian;
use App\Modul as Modul_learn;
use App\Ujian as Ujian;
use App\Trainee as Trainee;
use Session;

class NilaiUjianController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function showTambahNilaiUjian()
  {
  	$idTrainee= Trainee::select(DB::raw("nisn_trainee, nama_trainee"))
        ->orderBy(DB::raw("nisn_trainee"))        
        ->get();
    $idModul_learn= Modul_learn::select(DB::raw("id_modul,nama_modul"))
        ->orderBy(DB::raw("id_modul"))        
        ->get(); 
    $idUjian= Ujian::select(DB::raw("id_ujian,judul_ujian"))
        ->orderBy(DB::raw("id_ujian"))        
        ->get();

    return view('admin.dashboard.nilai_ujian.tambah_nilai_ujian')
		->with('Trainee', $idTrainee)
        ->with('Modul_learn', $idModul_learn)
        ->with('Ujian', $idUjian);
  }

  public function index()
  {               
    $dataNilaiUjian = DB::table('nilai_ujian_trainees')   
     ->join('ujians', 'nilai_ujian_trainees.id_ujian', '=', 'ujians.id_ujian')                                   			       
     ->join('moduls', 'nilai_ujian_trainees.id_modul', '=', 'moduls.id_modul')
     ->join('trainees', 'nilai_ujian_trainees.nisn_trainee', '=', 'trainees.nisn_trainee')
     ->select('nilai_ujian_trainees.*', 'trainees.nama_trainee', 'moduls.nama_modul', 'ujians.judul_ujian')
     ->get();
        
    $data = array('nilai_ujian' => $dataNilaiUjian);   
    return view('admin.dashboard.nilai_ujian.nilai_ujian',$data);
  }    

 public function hapus($id_nilai_ujian_trainee )
  { 
  
    $id_nilai_ujian_trainee  = NilaiTugas::where('id_nilai_ujian_trainee ', '=', $id_nilai_ujian_trainee )->first();

    if ($id_nilai_ujian_trainee  == null)
      app::abort(404);
    
    Session::flash('flash_message', 'Data Nilai Ujian  : "'.$id_nilai_ujian_trainee ->nisn_trainee.'" Berhasil dihapus.');

    $id_nilai_ujian_trainee ->delete();
    
    return Redirect::action('Admin\NilaiUjianController@index');

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
          	'nisn_trainee.required' 	=> 'NISN Trainee dibutuhkan.',          	           
            'id_modul.required' 	=> 'ID Modul dibutuhkan.',            
            'id_ujian.required' 	=> 'ID Ujian dibutuhkan.',                              
            'nilai_ujian.required' 	=> 'Nilai Ujian dibutuhkan.', 
                     
        );

        $aturan = array(
            'nisn_trainee'  	=> 'required',          
            'id_modul'  	=> 'required',
            'id_ujian'  	=> 'required',            
            'nilai_ujian'  	=> 'required',                      
        );        

        $validator = Validator::make($input,$aturan, $pesan);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses

        $nilai_ujian = new NilaiUjian;
        $nilai_ujian->nisn_trainee    = $request['nisn_trainee'];
        $nilai_ujian->id_modul     	= $request['id_modul'];
        $nilai_ujian->id_ujian     	= $request['id_ujian'];
        $nilai_ujian->nilai_ujian   = $request['nilai_ujian'];
                                                    
        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $nilai_ujian->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data Nilai Ujian "'.$request['nisn_trainee'].'" Berhasil disimpan.');

        return Redirect::action('Admin\NilaiUjianController@index');
  }  

 public function edit($id_nilai_ujian_trainee )
    {
        
        $data = NilaiTugas::find($id_nilai_ujian_trainee );
        $idTrainee= Trainee::select(DB::raw("nisn_trainee, nama_trainee"))
            ->orderBy(DB::raw("nisn_trainee"))        
            ->get();
        $idModul_learn= Modul_learn::select(DB::raw("id_modul,nama_modul"))
        ->orderBy(DB::raw("id_modul"))        
        ->get();
	    $idUjian= Ujian::select(DB::raw("id_ujian,judul_ujian"))
	        ->orderBy(DB::raw("id_ujian"))        
	        ->get();	    			
        
        return view('admin.dashboard.nilai_ujian.edit_nilai_ujian',$data)
                ->with('Trainee', $idTrainee)
		        ->with('Modul_learn', $idModul_learn)
		        ->with('Ujian', $idUjian);

    }

 public function simpanedit(Request $request, $id_nilai_ujian_trainee )
    {
        $input =$request->all();
        $messages = [
			'nisn_trainee.required' 	=> 'NISN Trainee dibutuhkan.',            
            'id_modul.required' 	=> 'ID Modul dibutuhkan.',            
            'id_ujian.required' 	=> 'ID Ujian dibutuhkan.',                              
            'nilai_ujian.required' 	=> 'Nilai Ujian dibutuhkan.',			
        ];        

        $validator = Validator::make($input, [
        	'nisn_trainee'  	=> 'required',         
            'id_modul'  	=> 'required',
            'id_ujian'  	=> 'required',            
            'nilai_ujian'  	=> 'required',                                                       
        ], $messages);
                     

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();          
        }
        # Bila validasi sukses
        $editNilai = NilaiTugas::find($id_nilai_ujian_trainee );
        $editNilai->nisn_trainee     	= $input['nisn_trainee'];
        $editNilai->id_modul     	= $input['id_modul'];
        $editNilai->id_ujian     	= $input['id_ujian'];                              
        $editNilai->nilai_ujian     = $input['nilai_ujian']; 

        if (! $editNilai->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Nilai : " '.$input['nisn_trainee'].'" Berhasil diubah.');

        return Redirect::action('Admin\NilaiUjianController@index'); 
    }
}

