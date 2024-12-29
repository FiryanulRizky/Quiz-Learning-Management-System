<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use DB;

use Validator;
use App\Http\Controllers\Controller;
use App\NilaiQuizTrainee as NilaiQuiz;
use App\Modul as Modul_learn;
use App\Quiz as Quiz;
use App\Trainee as Trainee;
use Session;

class NilaiQuizController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function showTambahNilaiQuiz()
  {
  	$idTrainee= Trainee::select(DB::raw("nik_trainee, nama_trainee"))
        ->orderBy(DB::raw("nik_trainee"))        
        ->get();
    $idModul_learn= Modul_learn::select(DB::raw("id_modul,nama_modul"))
        ->orderBy(DB::raw("id_modul"))        
        ->get(); 
    $idQuiz= Quiz::select(DB::raw("id_quiz,judul_quiz"))
        ->orderBy(DB::raw("id_quiz"))        
        ->get();

    return view('admin.dashboard.nilai_quiz.tambah_nilai_quiz')
		->with('Trainee', $idTrainee)
        ->with('Modul_learn', $idModul_learn)
        ->with('Quiz', $idQuiz);
  }

  public function index()
  {               
    $dataNilaiQuiz = DB::table('nilai_quiz_trainees')   
     ->join('quizs', 'nilai_quiz_trainees.id_quiz', '=', 'quizs.id_quiz')                                   			       
     ->join('moduls', 'nilai_quiz_trainees.id_modul', '=', 'moduls.id_modul')
     ->join('trainees', 'nilai_quiz_trainees.nik_trainee', '=', 'trainees.nik_trainee')
     ->select('nilai_quiz_trainees.*', 'trainees.nama_trainee', 'moduls.nama_modul', 'quizs.judul_quiz')
     ->get();
        
    $data = array('nilai_quiz' => $dataNilaiQuiz);   
    return view('admin.dashboard.nilai_quiz.nilai_quiz',$data);
  }    

 public function hapus($id_nilai_quiz_trainee )
  { 
  
    $id_nilai_quiz_trainee  = NilaiTugas::where('id_nilai_quiz_trainee ', '=', $id_nilai_quiz_trainee )->first();

    if ($id_nilai_quiz_trainee  == null)
      app::abort(404);
    
    Session::flash('flash_message', 'Data Nilai Quiz  : "'.$id_nilai_quiz_trainee ->nik_trainee.'" Berhasil dihapus.');

    $id_nilai_quiz_trainee ->delete();
    
    return Redirect::action('Admin\NilaiQuizController@index');

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
            'id_quiz.required' 	=> 'ID Quiz dibutuhkan.',                              
            'nilai_quiz.required' 	=> 'Nilai Quiz dibutuhkan.', 
                     
        );

        $aturan = array(
            'nik_trainee'  	=> 'required',          
            'id_modul'  	=> 'required',
            'id_quiz'  	=> 'required',            
            'nilai_quiz'  	=> 'required',                      
        );        

        $validator = Validator::make($input,$aturan, $pesan);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses

        $nilai_quiz = new NilaiQuiz;
        $nilai_quiz->nik_trainee    = $request['nik_trainee'];
        $nilai_quiz->id_modul     	= $request['id_modul'];
        $nilai_quiz->id_quiz     	= $request['id_quiz'];
        $nilai_quiz->nilai_quiz   = $request['nilai_quiz'];
                                                    
        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $nilai_quiz->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data Nilai Quiz "'.$request['nik_trainee'].'" Berhasil disimpan.');

        return Redirect::action('Admin\NilaiQuizController@index');
  }  

 public function edit($id_nilai_quiz_trainee )
    {
        
        $data = NilaiTugas::find($id_nilai_quiz_trainee );
        $idTrainee= Trainee::select(DB::raw("nik_trainee, nama_trainee"))
            ->orderBy(DB::raw("nik_trainee"))        
            ->get();
        $idModul_learn= Modul_learn::select(DB::raw("id_modul,nama_modul"))
        ->orderBy(DB::raw("id_modul"))        
        ->get();
	    $idQuiz= Quiz::select(DB::raw("id_quiz,judul_quiz"))
	        ->orderBy(DB::raw("id_quiz"))        
	        ->get();	    			
        
        return view('admin.dashboard.nilai_quiz.edit_nilai_quiz',$data)
                ->with('Trainee', $idTrainee)
		        ->with('Modul_learn', $idModul_learn)
		        ->with('Quiz', $idQuiz);

    }

 public function simpanedit(Request $request, $id_nilai_quiz_trainee )
    {
        $input =$request->all();
        $messages = [
			'nik_trainee.required' 	=> 'NISN Trainee dibutuhkan.',            
            'id_modul.required' 	=> 'ID Modul dibutuhkan.',            
            'id_quiz.required' 	=> 'ID Quiz dibutuhkan.',                              
            'nilai_quiz.required' 	=> 'Nilai Quiz dibutuhkan.',			
        ];        

        $validator = Validator::make($input, [
        	'nik_trainee'  	=> 'required',         
            'id_modul'  	=> 'required',
            'id_quiz'  	=> 'required',            
            'nilai_quiz'  	=> 'required',                                                       
        ], $messages);
                     

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();          
        }
        # Bila validasi sukses
        $editNilai = NilaiTugas::find($id_nilai_quiz_trainee );
        $editNilai->nik_trainee     	= $input['nik_trainee'];
        $editNilai->id_modul     	= $input['id_modul'];
        $editNilai->id_quiz     	= $input['id_quiz'];                              
        $editNilai->nilai_quiz     = $input['nilai_quiz']; 

        if (! $editNilai->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Nilai : " '.$input['nik_trainee'].'" Berhasil diubah.');

        return Redirect::action('Admin\NilaiQuizController@index'); 
    }
}

