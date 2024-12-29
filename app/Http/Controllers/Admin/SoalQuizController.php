<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use DB;
use Auth;

use Validator;
use App\Http\Controllers\Controller;
use App\Quiz as Quiz;
use App\Soal as Soal;
use App\Trainee as Trainee;
use App\Trainer as Trainer;
use App\SoalHasQuiz as SoalHasQuiz;
use App\Modul as Modul;
use App\JawabanSoalQuiz as Jawaban;
use App\TraineeJawabQuizPilihanGanda as TraineeJawabQuizPilihanGanda;
use App\NilaiQuizPilihanGandaTrainee as NilaiQuizPilihanGanda;
use Session;

class SoalQuizController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function detail($id_soal)
  { 
      $dataSoal = Soal::find($id_soal);         
      $JawabanSoal = DB::table('jawaban_soal_quizs')       
            ->join('soals','jawaban_soal_quizs.id_soal','=','soals.id_soal')       
            ->where('jawaban_soal_quizs.id_soal', $id_soal)
            ->select('jawaban_soal_quizs.*', 'soals.*') 
            ->get();

      $soal_quiz = Soal::orderBy('id_soal')->get();   
      $dataQuiz = DB::table('soals')   
         ->join('quizs','soals.id_quiz','=','quizs.id_quiz')
         ->where('soals.id_soal', $id_soal)
         ->select('quizs.*', 'soals.*')
         ->get();     
         // dd($JawabanSoal[0]->id_soal);
         // dd($dataSoal);         
      return view('admin.dashboard.soal_quiz.detail_soal',$dataSoal)                
             ->with('quiz', $dataQuiz)              
             ->with('soal', $JawabanSoal); 
  }

  public function detail_trainer($id_soal)
  { 
      $dataSoal = Soal::find($id_soal);         
      $JawabanSoal = DB::table('jawaban_soal_quizs')       
            ->join('soals','jawaban_soal_quizs.id_soal','=','soals.id_soal')       
            ->where('jawaban_soal_quizs.id_soal', $id_soal)
            ->select('jawaban_soal_quizs.*', 'soals.*') 
            ->get();

      $soal_quiz = Soal::orderBy('id_soal')->get();   
      $dataQuiz = DB::table('soals')   
         ->join('quizs','soals.id_quiz','=','quizs.id_quiz')
         ->where('soals.id_soal', $id_soal)
         ->select('quizs.*', 'soals.*')
         ->get();     
         // dd($JawabanSoal[0]->id_soal);
         // dd($dataSoal);         
      return view('admin.dashboard.soal_quiz.detail_soal',$dataSoal)                
             ->with('quiz', $dataQuiz)              
             ->with('soal', $JawabanSoal); 
  }

  public function showTambahSoalQuiz()
  {
    if (Auth::user()->level == 11) {     
      $dataQuiz = DB::table('quizs')   
           ->join('moduls','quizs.id_modul','=','moduls.id_modul')
           ->select('quizs.*', 'moduls.nama_modul')
           ->get();   
    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
      $dataQuiz = DB::table('quizs')   
           ->join('moduls','quizs.id_modul','=','moduls.id_modul')
           ->select('quizs.*', 'moduls.nama_modul')
           ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
           ->get();      
    }     
    $data = array('quiz' => $dataQuiz);        
    return view('admin.dashboard.soal_quiz.tambah_soal_quiz',$data);         
  }

public function index()
  { 
    $countSoalPilgan   = Soal::where('jenis_soal', '=', 'Pilihan Ganda')->count(); 
    $countSoalEssay   = Soal::where('jenis_soal', '=', 'Essay')->count();     
    
    if (Auth::user()->level == 11) {
      $dataSoalQuiz = DB::table('soals')   
               ->join('quizs', 'soals.id_quiz', '=', 'quizs.id_quiz') 
               ->leftjoin('moduls','quizs.id_modul','=','moduls.id_modul')
               ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
               ->select('soals.*', 'quizs.*', 'moduls.nama_modul', 'trainers.nama_trainer')
               ->get();             
    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
      $dataSoalQuiz = DB::table('soals')   
               ->join('quizs', 'soals.id_quiz', '=', 'quizs.id_quiz') 
               ->leftjoin('moduls','quizs.id_modul','=','moduls.id_modul')
               ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
               ->select('soals.*', 'quizs.*', 'moduls.nama_modul', 'trainers.nama_trainer')
               ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
               ->get();      
    }

    $dataJawabanSoal = DB::table('jawaban_soal_quizs')         
         ->join('soals','jawaban_soal_quizs.id_soal','=','soals.id_soal')
         ->leftjoin('quizs', 'soals.id_quiz', '=', 'quizs.id_quiz')
         ->select('jawaban_soal_quizs.poin', 'jawaban_soal_quizs.id_soal')
         ->get();
    
    $data = array('soal_quiz' => $dataSoalQuiz);   
    $maxPoint = 0;
    foreach ($dataJawabanSoal as $jawaban)
        if ($jawaban->poin > $maxPoint)
            (int)$maxPoint = $jawaban->poin;
    // return $maxPoint;
    // dd($maxPoint);            
    return view('admin.dashboard.soal_quiz.soal_quiz',$data)
            ->with('countSoalPilgan', $countSoalPilgan)
            ->with('countSoalEssay', $countSoalEssay)
            ->with('poin', $maxPoint);
  }    

public function hapus($id_soal)
  {   
    $id_soal = Soal::where('id_soal', '=', $id_soal)->first();
    if ($id_soal == null)
      app::abort(404);    
    Session::flash('flash_message', 'Data Soal Quiz "'.$id_soal->jenis_soal.'" - "'.$id_soal->no_soal.'" Berhasil dihapus.');
    $id_soal->delete();    
    if (Auth::user()->level == 11) {
      return redirect('admin/quiz/'.$id_soal->id_quiz.'/detail');
    }elseif (Auth::user()->level == 12) {
      return redirect('trainer/quiz/'.$id_soal->id_quiz.'/detail');
    }

  }

  protected function tambah(Request $request)
  {
      $input =$request->all();
      $gambar = $request['gambar'];
      $jenis_soal = $request['jenis_soal'];          
      $msg = $request->all();
      $mes = 'tidak ada yang dipilih';
      $pesan_essay_gbr = array(
          'jenis_soal.required' => 'Jenis Soal dibutuhkan.', 
          'pertanyaan.required' => 'Pertanyaan dibutuhkan.',             
          'gambar.required'     => 'Gambar dibutuhkan.', 
          'id_quiz.required'  => 'ID Modul dibutuhkan.', );
      $aturan_essay_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'gambar'      => 'required',
          'id_quiz'      => 'required', );
      $pesan_pilgan_gbr = array(
          'jenis_soal.required' => 'Jenis Soal dibutuhkan.', 
          'pertanyaan.required' => 'Pertanyaan dibutuhkan.',             
          'gambar.required'     => 'Gambar dibutuhkan.', 
          'id_quiz.required'  => 'ID Modul dibutuhkan.', 
          'Jawaban_A'       => 'Jawaban_A dibutuhkan',
          'Jawaban_B'       => 'Jawaban_B dibutuhkan',
          'Jawaban_C'       => 'Jawaban_C dibutuhkan',
          'Jawaban_D'       => 'Jawaban_D dibutuhkan',
          'Point_Jawaban_A' => 'Point_Jawaban_A dibutuhkan',
          'Point_Jawaban_B' => 'Point_Jawaban_B dibutuhkan',
          'Point_Jawaban_C' => 'Point_Jawaban_C dibutuhkan',
          'Point_Jawaban_D' => 'Point_Jawaban_D dibutuhkan',
        );
      $aturan_pilgan_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'gambar'      => 'required',
          'id_quiz'      => 'required', 
          'Jawaban_A'       => 'required',
          'Jawaban_B'       => 'required',
          'Jawaban_C'       => 'required',
          'Jawaban_D'       => 'required',
          'Point_Jawaban_A' => 'numeric|min:0',
          'Point_Jawaban_B' => 'numeric|min:0',
          'Point_Jawaban_C' => 'numeric|min:0',
          'Point_Jawaban_D' => 'numeric|min:0',
        );
      $pesan_pilgan_no_gbr = array(
          'jenis_soal.required' => 'Jenis Soal dibutuhkan.', 
          'pertanyaan.required' => 'Pertanyaan dibutuhkan.',                         
          'id_quiz.required'  => 'ID Modul dibutuhkan.', 
          'Jawaban_A'       => 'Jawaban_A dibutuhkan',
          'Jawaban_B'       => 'Jawaban_B dibutuhkan',
          'Jawaban_C'       => 'Jawaban_C dibutuhkan',
          'Jawaban_D'       => 'Jawaban_D dibutuhkan',
          'Point_Jawaban_A' => 'Point_Jawaban_A dibutuhkan',
          'Point_Jawaban_B' => 'Point_Jawaban_B dibutuhkan',
          'Point_Jawaban_C' => 'Point_Jawaban_C dibutuhkan',
          'Point_Jawaban_D' => 'Point_Jawaban_D dibutuhkan',
        );
      $aturan_pilgan_no_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'id_quiz'      => 'required', 
          'Jawaban_A'       => 'required',
          'Jawaban_B'       => 'required',
          'Jawaban_C'       => 'required',
          'Jawaban_D'       => 'required',
          'Point_Jawaban_A' => 'numeric|min:0',
          'Point_Jawaban_B' => 'numeric|min:0',
          'Point_Jawaban_C' => 'numeric|min:0',
          'Point_Jawaban_D' => 'numeric|min:0',
        );
      $pesan_essay_no_gbr = array(
          'jenis_soal.required' => 'Jenis Soal dibutuhkan.', 
          'pertanyaan.required' => 'Pertanyaan dibutuhkan.',                         
          'id_quiz.required'  => 'ID Modul dibutuhkan.',             
        );
      $aturan_essay_no_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'id_quiz'      => 'required',             
        );

         if ($jenis_soal == 'Essay') {
          if (!empty($gambar)) {                  
            // dd($pesan_essay_gbr, $aturan_essay_gbr);  
            // dd($jenis_soal, $gambar);    
            $validator = Validator::make($input,$aturan_essay_gbr, $pesan_essay_gbr);
            if($validator->fails())
              # Kembali kehalaman yang sama dengan pesan error
                return Redirect::back()->withErrors($validator)->withInput();
            $soal_quiz->gambar       = $request['gambar'];
            
            $gambar = $request->file('gambar');         
            $namaGambar = $gambar->getClientOriginalName();
            $request->file('gambar')->move('upload_gambar', $namaGambar);
            
            # Bila validasi sukses
            $soal_quiz = new Soal;
            $soal_quiz->jenis_soal     = $request['jenis_soal'];        
            $soal_quiz->pertanyaan     = $request['pertanyaan'];        
            $soal_quiz->gambar         = $namaGambar; //$request['gambar'];        
            $soal_quiz->id_quiz       = $request['id_quiz'];                                  
            //melakukan save, jika gagal (return value false) lakukan harakiri
            //error kode 500 - internal server error
            if (! $soal_quiz->save() )
              App::abort(500);
            Session::flash('flash_message', 'Data Soal Quiz "'.$request['jenis_soal'].'" Berhasil disimpan.');
                if (Auth::user()->level == 11) {
                  return redirect('admin/quiz/'.$request['id_quiz'].'/detail');
                }elseif (Auth::user()->level == 12) {
                  return redirect('trainer/quiz/'.$request['id_quiz'].'/detail');
                }                    
          }                      
            // dd($pesan_essay_no_gbr, $aturan_essay_no_gbr); 
            // dd($jenis_soal); 
            $validator = Validator::make($input,$aturan_essay_no_gbr, $pesan_essay_no_gbr);
            if($validator->fails()){
              # Kembali kehalaman yang sama dengan pesan error
                return Redirect::back()->withErrors($validator)->withInput();
              } 
            # Bila validasi sukses
            $soal_quiz = new Soal;
            $soal_quiz->jenis_soal     = $request['jenis_soal'];        
            $soal_quiz->pertanyaan     = $request['pertanyaan'];               
            $soal_quiz->id_quiz       = $request['id_quiz'];                                  
            //melakukan save, jika gagal (return value false) lakukan harakiri
            //error kode 500 - internal server error
            if (! $soal_quiz->save() )
              App::abort(500);
            Session::flash('flash_message', 'Data Soal Quiz "'.$request['jenis_soal'].'" Berhasil disimpan.');
                if (Auth::user()->level == 11) {
                  return redirect('admin/quiz/'.$request['id_quiz'].'/detail');
                }elseif (Auth::user()->level == 12) {
                  return redirect('trainer/quiz/'.$request['id_quiz'].'/detail');
                }         
         }
         elseif ($jenis_soal == 'Pilihan Ganda') {
          if (!empty($gambar)) {
            // dd($pesan_pilgan_gbr, $aturan_pilgan_gbr); 
            // dd($jenis_soal, $gambar);
            $validator = Validator::make($input,$aturan_pilgan_gbr, $pesan_pilgan_gbr);
            if($validator->fails())
              # Kembali kehalaman yang sama dengan pesan error
                return Redirect::back()->withErrors($validator)->withInput();              
                # Bila validasi sukses

                $gambar = $request->file('gambar');         
                $namaGambar = $gambar->getClientOriginalName();
                $request->file('gambar')->move('upload_gambar', $namaGambar);

                $soal_quiz = new Soal;
                $soal_quiz->jenis_soal     = $request['jenis_soal'];        
                $soal_quiz->pertanyaan     = $request['pertanyaan'];
                $soal_quiz->gambar         = $namaGambar; //$request['gambar'];                  
                $soal_quiz->id_quiz       = $request['id_quiz'];                                 
                if (! $soal_quiz->save() )
                  throw new Exception('Gagal Menyimpan Soal');

                /// buat sol_has_quiz
                $soal_has_quiz = new SoalHasQuiz();
                $soal_has_quiz->id_soal = $soal_quiz->id_soal;
                $soal_has_quiz->id_quiz = $soal_quiz->id_quiz;
                if (! $soal_has_quiz->save())
                  throw new Exception('Gagal Menyimpan Soal Has Quiz');

                // Buat Jawaban
                $jawaban1 = new Jawaban();// create baru jawaban a                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_A"
                $jawaban1->jawaban  = $request->input('Jawaban_A');
                $jawaban1->is_benar = $request->input('a_is_benar');
                $jawaban1->poin     = $request->input('Point_Jawaban_A');
                $jawaban1->id_soal  = $soal_quiz->id_soal;
                if (!$jawaban1->save())
                    throw new Exception('Gagal Menyimpan Jawaban A');
                
                $jawaban2 = new Jawaban();// create baru jawaban b                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_B"
                $jawaban2->jawaban  = $request->input('Jawaban_B');
                $jawaban2->is_benar = $request->input('b_is_benar');
                $jawaban2->poin     = $request->input('Point_Jawaban_B');
                $jawaban2->id_soal  = $soal_quiz->id_soal;
                if (!$jawaban2->save())
                    throw new Exception('Gagal Menyimpan Jawaban B');
                
                $jawaban3 = new Jawaban();// create baru jawaban c                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_C"
                $jawaban3->jawaban  = $request->input('Jawaban_C');
                $jawaban3->is_benar = $request->input('c_is_benar');
                $jawaban3->poin     = $request->input('Point_Jawaban_C');
                $jawaban3->id_soal  = $soal_quiz->id_soal;
                if (!$jawaban3->save())
                    throw new Exception('Gagal Menyimpan Jawaban C');
                
                $jawaban4 = new Jawaban();// create baru jawaban d                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_D"
                $jawaban4->jawaban  = $request->input('Jawaban_D');
                $jawaban4->is_benar = $request->input('d_is_benar');
                $jawaban4->poin     = $request->input('Point_Jawaban_D');
                $jawaban4->id_soal  = $soal_quiz->id_soal;
                if (!$jawaban4->save())
                    throw new Exception('Gagal Menyimpan Jawaban D');

                Session::flash('flash_message', 'Data Soal Quiz "'.$request['jenis_soal'].'" Berhasil disimpan.');
                if (Auth::user()->level == 11) {
                  return redirect('admin/quiz/'.$request['id_quiz'].'/detail');
                }elseif (Auth::user()->level == 12) {
                  return redirect('trainer/quiz/'.$request['id_quiz'].'/detail');
                }                           
          }
          
            // dd($pesan_pilgan_no_gbr, $aturan_pilgan_no_gbr); 
            // dd($jenis_soal);
          $validator = Validator::make($input,$aturan_pilgan_no_gbr, $pesan_pilgan_no_gbr);
            if($validator->fails())
              # Kembali kehalaman yang sama dengan pesan error
                return Redirect::back()->withErrors($validator)->withInput();                             
                # Bila validasi sukses
                $soal_quiz = new Soal;
                $soal_quiz->jenis_soal     = $request['jenis_soal'];        
                $soal_quiz->pertanyaan     = $request['pertanyaan'];                                
                $soal_quiz->id_quiz       = $request['id_quiz'];                                 
                if (! $soal_quiz->save() )
                  throw new Exception('Gagal Menyimpan Soal');

                /// buat sol_has_quiz
                $soal_has_quiz = new SoalHasQuiz();
                $soal_has_quiz->id_soal = $soal_quiz->id_soal;
                $soal_has_quiz->id_quiz = $soal_quiz->id_quiz;
                if (! $soal_has_quiz->save())
                  throw new Exception('Gagal Menyimpan Soal Has Quiz');
                
                $jawaban1 = new Jawaban();// create baru jawaban a                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_A"
                $jawaban1->jawaban  = $request->input('Jawaban_A');
                $jawaban1->is_benar = $request->input('a_is_benar');
                $jawaban1->poin     = $request->input('Point_Jawaban_A');
                $jawaban1->id_soal  = $soal_quiz->id_soal;
                if (!$jawaban1->save())
                    throw new Exception('Gagal Menyimpan Jawaban A');
                
                $jawaban2 = new Jawaban();// create baru jawaban b                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_B"
                $jawaban2->jawaban  = $request->input('Jawaban_B');
                $jawaban2->is_benar = $request->input('b_is_benar');
                $jawaban2->poin     = $request->input('Point_Jawaban_B');
                $jawaban2->id_soal  = $soal_quiz->id_soal;
                if (!$jawaban2->save())
                    throw new Exception('Gagal Menyimpan Jawaban B');
                
                $jawaban3 = new Jawaban();// create baru jawaban c                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_C"
                $jawaban3->jawaban  = $request->input('Jawaban_C');
                $jawaban3->is_benar = $request->input('c_is_benar');
                $jawaban3->poin     = $request->input('Point_Jawaban_C');
                $jawaban3->id_soal  = $soal_quiz->id_soal;
                if (!$jawaban3->save())
                    throw new Exception('Gagal Menyimpan Jawaban C');
                
                $jawaban4 = new Jawaban();// create baru jawaban d                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_D"
                $jawaban4->jawaban  = $request->input('Jawaban_D');
                $jawaban4->is_benar = $request->input('d_is_benar');
                $jawaban4->poin     = $request->input('Point_Jawaban_D');
                $jawaban4->id_soal  = $soal_quiz->id_soal;
                if (!$jawaban4->save())
                    throw new Exception('Gagal Menyimpan Jawaban D');
                  
                Session::flash('flash_message', 'Data Soal Quiz "'.$request['jenis_soal'].'" Berhasil disimpan.');
                if (Auth::user()->level == 11) {
                  return redirect('admin/quiz/'.$request['id_quiz'].'/detail');
                }elseif (Auth::user()->level == 12) {
                  return redirect('trainer/quiz/'.$request['id_quiz'].'/detail');
                }
         }         
         else {          
          $validator = Validator::make($input,$aturan_essay_gbr, $pesan_essay_gbr);
          if($validator->fails()){
              return Redirect::back()->withErrors($validator)->withInput();
            }                                                          
         }               
      }


 public function edit($id_soal)
    {        
        $dataSoal = Soal::find($id_soal);         
        $JawabanSoal = DB::table('jawaban_soal_quizs')              
              ->where('jawaban_soal_quizs.id_soal', $id_soal)
              ->select('jawaban_soal_quizs.*') 
              ->get(); 
        if (Auth::user()->level == 11) {     
        $dataQuiz = DB::table('quizs')   
               ->join('moduls','quizs.id_modul','=','moduls.id_modul')
               ->select('quizs.*', 'moduls.nama_modul')
               ->get();   
        }elseif (Auth::user()->level == 12) {
          $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
          $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
          $dataQuiz = DB::table('quizs')   
               ->join('moduls','quizs.id_modul','=','moduls.id_modul')
               ->select('quizs.*', 'moduls.nama_modul')
               ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
               ->get();      
        }    

        return view('admin.dashboard.soal_quiz.edit_soal_quiz',$dataSoal)                
               ->with('quiz', $dataQuiz)              
               ->with('jawaban', $JawabanSoal); 
    }

 public function simpanedit(Request $request, $id_soal)
    {                      
      $jawabans = Jawaban::where('id_soal', $id_soal)->get();
        $jawaban = array();
        foreach ($jawabans as $j) {
          $jawaban[] = $j;         
        }        

      $input =$request->all();
      // cek apakah ada file baru di form ?
        if ($request->hasFile('gambar')) {
          $gambar = $input['gambar'];
        }else{
          $gambar = null;
        }

      $jenis_soal = $input['jenis_soal'];                      
      $pesan_essay_gbr = array(
          'jenis_soal.required' => 'Jenis Soal dibutuhkan.', 
          'pertanyaan.required' => 'Pertanyaan dibutuhkan.',             
          'gambar.required'     => 'Gambar dibutuhkan.', 
          'id_quiz.required'  => 'ID Modul dibutuhkan.', );
      $aturan_essay_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'gambar'      => 'required',
          'id_quiz'      => 'required', );
      $pesan_pilgan_gbr = array(
          'jenis_soal.required' => 'Jenis Soal dibutuhkan.', 
          'pertanyaan.required' => 'Pertanyaan dibutuhkan.',             
          'gambar.required'     => 'Gambar dibutuhkan.', 
          'id_quiz.required'  => 'ID Modul dibutuhkan.', 
          'Jawaban_A'       => 'Jawaban_A dibutuhkan',
          'Jawaban_B'       => 'Jawaban_B dibutuhkan',
          'Jawaban_C'       => 'Jawaban_C dibutuhkan',
          'Jawaban_D'       => 'Jawaban_D dibutuhkan',
          'Point_Jawaban_A' => 'Point_Jawaban_A dibutuhkan',
          'Point_Jawaban_B' => 'Point_Jawaban_B dibutuhkan',
          'Point_Jawaban_C' => 'Point_Jawaban_C dibutuhkan',
          'Point_Jawaban_D' => 'Point_Jawaban_D dibutuhkan',
        );
      $aturan_pilgan_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'gambar'      => 'sometimes',
          'id_quiz'      => 'required', 
          'Jawaban_A'       => 'required',
          'Jawaban_B'       => 'required',
          'Jawaban_C'       => 'required',
          'Jawaban_D'       => 'required',
          'Point_Jawaban_A' => 'numeric|min:0',
          'Point_Jawaban_B' => 'numeric|min:0',
          'Point_Jawaban_C' => 'numeric|min:0',
          'Point_Jawaban_D' => 'numeric|min:0',
        );
      $pesan_pilgan_no_gbr = array(
          'jenis_soal.required' => 'Jenis Soal dibutuhkan.', 
          'pertanyaan.required' => 'Pertanyaan dibutuhkan.',                         
          'id_quiz.required'  => 'ID Modul dibutuhkan.', 
          'Jawaban_A'       => 'Jawaban_A dibutuhkan',
          'Jawaban_B'       => 'Jawaban_B dibutuhkan',
          'Jawaban_C'       => 'Jawaban_C dibutuhkan',
          'Jawaban_D'       => 'Jawaban_D dibutuhkan',
          'Point_Jawaban_A' => 'Point_Jawaban_A dibutuhkan',
          'Point_Jawaban_B' => 'Point_Jawaban_B dibutuhkan',
          'Point_Jawaban_C' => 'Point_Jawaban_C dibutuhkan',
          'Point_Jawaban_D' => 'Point_Jawaban_D dibutuhkan',
        );
      $aturan_pilgan_no_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'id_quiz'      => 'required', 
          'Jawaban_A'       => 'required',
          'Jawaban_B'       => 'required',
          'Jawaban_C'       => 'required',
          'Jawaban_D'       => 'required',
          'Point_Jawaban_A' => 'numeric|min:0',
          'Point_Jawaban_B' => 'numeric|min:0',
          'Point_Jawaban_C' => 'numeric|min:0',
          'Point_Jawaban_D' => 'numeric|min:0',
        );
      $pesan_essay_no_gbr = array(
          'jenis_soal.required' => 'Jenis Soal dibutuhkan.', 
          'pertanyaan.required' => 'Pertanyaan dibutuhkan.',                         
          'id_quiz.required'  => 'ID Modul dibutuhkan.',             
        );
      $aturan_essay_no_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'id_quiz'      => 'required',             
        );

         if ($jenis_soal == 'Essay') {
          if (!empty($gambar)) {                                
            $validator = Validator::make($input,$aturan_essay_gbr, $pesan_essay_gbr);
            if($validator->fails())              
                return Redirect::back()->withErrors($validator)->withInput();
            # Bila validasi sukses
            $SoalQuiz = Soal::findOrFail($id_soal);
            $gambar = $input['gambar'];         
            $namaGambar = $gambar->getClientOriginalName();            
            
            if (!$SoalQuiz->gambar == "") {
              // hapus gambar lama
              $image_path = public_path().'/upload_gambar/'.$SoalQuiz->gambar;
              unlink($image_path);
            }
            // upload gambar baru
            $input['gambar']->move('upload_gambar', $namaGambar);
            
            $editSoalQuiz = Soal::find($id_soal);
            $editSoalQuiz->jenis_soal     = $input['jenis_soal'];        
            $editSoalQuiz->pertanyaan     = $input['pertanyaan'];        
            $soal_quiz->gambar            = $namaGambar; //$request['gambar'];        
            $editSoalQuiz->id_quiz       = $input['id_quiz'];                                  
            if (! $editSoalQuiz->save() )
              App::abort(500);
            Session::flash('flash_message', 'Data Soal Quiz "'.$input['jenis_soal'].'" Berhasil disimpan.');            
            if (Auth::user()->level == 11) {
              return redirect('admin/soal_quiz/');
            }elseif (Auth::user()->level == 12) {
              return redirect('trainer/soal_quiz/');
            }                   
          }                      
            // dd($pesan_essay_no_gbr, $aturan_essay_no_gbr); 
            // dd($jenis_soal); 
            $validator = Validator::make($input,$aturan_essay_no_gbr, $pesan_essay_no_gbr);
            if($validator->fails()){
              # Kembali kehalaman yang sama dengan pesan error
                return Redirect::back()->withErrors($validator)->withInput();
              } 

            $editSoalQuiz = Soal::find($id_soal);
            $editSoalQuiz->jenis_soal     = $input['jenis_soal'];        
            $editSoalQuiz->pertanyaan     = $input['pertanyaan'];               
            $editSoalQuiz->id_quiz       = $input['id_quiz'];                                  
            
            if (! $editSoalQuiz->save() )
              App::abort(500);
            Session::flash('flash_message', 'Data Soal Quiz "'.$input['jenis_soal'].'" Berhasil disimpan.');
            if (Auth::user()->level == 11) {
              return redirect('admin/soal_quiz/');
            }elseif (Auth::user()->level == 12) {
              return redirect('trainer/soal_quiz/');
            }                             
         }
         elseif ($jenis_soal == 'Pilihan Ganda') {
          if (!empty($gambar)) { 

            $validator = Validator::make($input,$aturan_pilgan_gbr, $pesan_pilgan_gbr);
            if($validator->fails())              
                return Redirect::back()->withErrors($validator)->withInput();              
            
                $SoalQuiz = Soal::findOrFail($id_soal);
                $gambar = $request->file('gambar');        
                $namaGambar = $gambar->getClientOriginalName();

                if (!$SoalQuiz->gambar == "") {
                  // hapus file lama
                  $image_path = public_path().'/upload_gambar/'.$SoalQuiz->gambar;
                  unlink($image_path);
                }
                
                // upload file baru
                $request->file('gambar')->move('upload_gambar', $namaGambar);
                // $input['gambar']->move('upload_gambar', $namaGambar);
              
                $editSoalQuiz = Soal::find($id_soal);
                $editSoalQuiz->jenis_soal     = $input['jenis_soal'];        
                $editSoalQuiz->pertanyaan     = $input['pertanyaan'];
                $editSoalQuiz->gambar            = $namaGambar; //$request['gambar'];                                                 
                $editSoalQuiz->id_quiz       = $input['id_quiz'];                                 
                if (! $editSoalQuiz->save() )
                  throw new Exception('Gagal Menyimpan Soal');

                /// buat sol_has_quiz
                $soal_has_quiz = new SoalHasQuiz();
                $soal_has_quiz->id_soal = $editSoalQuiz->id_soal;
                $soal_has_quiz->id_quiz = $editSoalQuiz->id_quiz;
                if (! $soal_has_quiz->save())
                  throw new Exception('Gagal Menyimpan Soal Has Quiz');
                
                $jawaban1 = $jawaban[0];// create baru jawaban a                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_A"
                $jawaban1->jawaban  = $request->input('Jawaban_A');
                $jawaban1->is_benar = $request->input('a_is_benar');
                $jawaban1->poin     = $request->input('Point_Jawaban_A');
                $jawaban1->id_soal  = $editSoalQuiz->id_soal;
                if (!$jawaban1->save())
                    throw new Exception('Gagal Menyimpan Jawaban A');
                
                $jawaban2 = $jawaban[1];// create baru jawaban b                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_B"
                $jawaban2->jawaban  = $request->input('Jawaban_B');
                $jawaban2->is_benar = $request->input('b_is_benar');
                $jawaban2->poin     = $request->input('Point_Jawaban_B');
                $jawaban2->id_soal  = $editSoalQuiz->id_soal;
                if (!$jawaban2->save())
                    throw new Exception('Gagal Menyimpan Jawaban B');
                
                $jawaban3 = $jawaban[2];// create baru jawaban c                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_C"
                $jawaban3->jawaban  = $request->input('Jawaban_C');
                $jawaban3->is_benar = $request->input('c_is_benar');
                $jawaban3->poin     = $request->input('Point_Jawaban_C');
                $jawaban3->id_soal  = $editSoalQuiz->id_soal;
                if (!$jawaban3->save())
                    throw new Exception('Gagal Menyimpan Jawaban C');
                
                $jawaban4 = $jawaban[3];// create baru jawaban d                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_D"
                $jawaban4->jawaban  = $request->input('Jawaban_D');
                $jawaban4->is_benar = $request->input('d_is_benar');
                $jawaban4->poin     = $request->input('Point_Jawaban_D');
                $jawaban4->id_soal  = $editSoalQuiz->id_soal;
                if (!$jawaban4->save())
                    throw new Exception('Gagal Menyimpan Jawaban D');

                Session::flash('flash_message', 'Data Soal Quiz "'.$input['jenis_soal'].'" Berhasil disimpan.');
                if (Auth::user()->level == 11) {
                  return redirect('admin/soal_quiz/');
                }elseif (Auth::user()->level == 12) {
                  return redirect('trainer/soal_quiz/');
                }
          }
          
          $validator = Validator::make($input,$aturan_pilgan_no_gbr, $pesan_pilgan_no_gbr);
            if($validator->fails())
              
                return Redirect::back()->withErrors($validator)->withInput();                             
                $editSoalQuiz = Soal::find($id_soal);
                $editSoalQuiz->jenis_soal     = $input['jenis_soal'];        
                $editSoalQuiz->pertanyaan     = $input['pertanyaan'];
                $editSoalQuiz->id_quiz       = $input['id_quiz'];                                 
                if (! $editSoalQuiz->save() )
                  throw new Exception('Gagal Menyimpan Soal');

                /// buat sol_has_quiz
                $soal_has_quiz = new SoalHasQuiz();
                $soal_has_quiz->id_soal = $editSoalQuiz->id_soal;
                $soal_has_quiz->id_quiz = $editSoalQuiz->id_quiz;
                if (! $soal_has_quiz->save())
                  throw new Exception('Gagal Menyimpan Soal Has Quiz');
                
                $jawaban1 = $jawaban[0]; 
                $jawaban1->jawaban  = $request->input('Jawaban_A');
                $jawaban1->is_benar = $request->input('a_is_benar');
                $jawaban1->poin     = $request->input('Point_Jawaban_A');
                $jawaban1->id_soal  = $editSoalQuiz->id_soal;
                // dd($jawaban1);

                if (! $jawaban1->save() )
                    throw new Exception('Gagal Menyimpan Jawaban A');
                
                $jawaban2 = $jawaban[1]; 
                $jawaban2->jawaban  = $request->input('Jawaban_B');
                $jawaban2->is_benar = $request->input('b_is_benar');
                $jawaban2->poin     = $request->input('Point_Jawaban_B');
                $jawaban2->id_soal  = $editSoalQuiz->id_soal;
                if (!$jawaban2->save())
                    throw new Exception('Gagal Menyimpan Jawaban B');
                
                $jawaban3 = $jawaban[2]; 
                $jawaban3->jawaban  = $request->input('Jawaban_C');
                $jawaban3->is_benar = $request->input('c_is_benar');
                $jawaban3->poin     = $request->input('Point_Jawaban_C');
                $jawaban3->id_soal  = $editSoalQuiz->id_soal;
                if (!$jawaban3->save())
                    throw new Exception('Gagal Menyimpan Jawaban C');
                
                $jawaban4 = $jawaban[3];                         
                $jawaban4->jawaban  = $request->input('Jawaban_D');
                $jawaban4->is_benar = $request->input('d_is_benar');
                $jawaban4->poin     = $request->input('Point_Jawaban_D');
                $jawaban4->id_soal  = $editSoalQuiz->id_soal;
          
                if (!$jawaban4->save())
                    throw new Exception('Gagal Menyimpan Jawaban D');
                  
          Session::flash('flash_message', 'Data Soal Quiz "'.$input['jenis_soal'].'" Berhasil diubah.');
          if (Auth::user()->level == 11) {
            return redirect('admin/quiz/'.$editSoalQuiz->id_quiz.'/detail');
            // return Redirect::back();
            // return Redirect::back();
          }elseif (Auth::user()->level == 12) {
            return redirect('trainer/quiz/'.$editSoalQuiz->id_quiz.'/detail');
            // return Redirect::back();
            // return Redirect::back();
          }
         }         
         else {          
          $validator = Validator::make($input,$aturan_essay_gbr, $pesan_essay_gbr);          
          if($validator->fails()){            
              return Redirect::back()->withErrors($validator)->withInput();
            }

         } 
    }

   /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($userjawablembarId, $soalId = 0)
    {
        try {
            $userJawabLembar = NilaiQuizPilihanGanda::find($userjawablembarId);                                   
            $id_user_trainee = Trainee::where('nik_trainee', $userJawabLembar->nik_trainee)->first()->id_user;                       

            if (!$userJawabLembar){
                Session::flash('flash_message', 'Quiz tidak ditemukan');
                return Redirect::back(); 
            }
            // cek apakah sama id_user trainee dengan id_user trainee yang akan start quiz.
            if (Auth::user()->id_user != $id_user_trainee){
                Session::flash('flash_message', 'Quiz ini bukan untuk anda');
                return Redirect::back(); 
            }

            //populate soal id
            $userJawabBelum = TraineeJawabQuizPilihanGanda::whereRaw('id_nilai_quiz_pilgan = ? and id_jawaban_soal_quiz is null', array($userJawabLembar->id_nilai_quiz_pilgan));
            $userJawabAll   = TraineeJawabQuizPilihanGanda::whereRaw('id_nilai_quiz_pilgan = ?', array($userJawabLembar->id_nilai_quiz_pilgan));            
            $soalIds        = $userJawabBelum->pluck('id_soal')->toArray();
            $AllsoalIds     = $userJawabAll->pluck('id_soal')->toArray();                        

            if (!$soalId)
                return Redirect::action('Admin\SoalQuizController@show', array($userJawabLembar->id_nilai_quiz_pilgan, $soalIds[0]));

            if (!in_array($soalId, $soalIds))
                throw new \Exception('Soal bukan termasuk dalam quiz');
              // dd($AllsoalIds->toArray(), $soalId);
            $nomor = array_keys($AllsoalIds, $soalId);
            $nomor = $nomor[0] + 1;

            //soal sudah terjawab semua
            $isLastSoal = false;
            if (sizeof($soalIds) == 1 && $soalId == $soalIds[0])
                $isLastSoal = true;

            $nextSoal = false;
            if (!$isLastSoal) {
                //get next soal
                //adalah soal terakhir
                $currentKey = array_keys($soalIds, $soalId);
                $currentKey = $currentKey[0];
                if ($soalIds[count($soalIds) - 1] == $soalId) {
                    //find sebelumnya
                    $nextSoal = $soalIds[0];
                } else {
                    $nextSoal = $soalIds[$currentKey + 1];
                }
            }
            
            $quiz = Quiz::find($userJawabLembar->id_quiz);
            $waktu_quiz = $quiz->waktu_quiz;

            $startTime = strtotime($userJawabLembar->wkt_mulai);
            $maxTime   = strtotime('+' . $waktu_quiz . ' minutes', $startTime);

            if ($userJawabLembar->wkt_selesai){
                Session::flash('flash_message', 'Anda sudah menyelesaikan kuis ini');
                return Redirect::back(); 
            }             

            //check waktu
            if (time() > $maxTime) {
                //update waktu selesai jika diperlukan
                if (!$userJawabLembar->wkt_selesai) {
                    $userJawabLembar->wkt_selesai = date('Y-m-d H:i:s');
                    $userJawabLembar->save();
                }
                Session::flash('flash_message', 'Waktu mengerjakan sudah habis');
                return Redirect::back();                 
            }

            if ($startTime > time()){
                Session::flash('flash_message', 'Waktu mengerjakan belum dimulai');
                return Redirect::back(); 
            }            

            $JawabanSoal = DB::table('jawaban_soal_quizs')       
                        ->join('soals','jawaban_soal_quizs.id_soal','=','soals.id_soal')       
                        ->where('jawaban_soal_quizs.id_soal', $soalId)
                        ->select('jawaban_soal_quizs.*', 'soals.*') 
                        ->get();

            if (!$JawabanSoal){
                Session::flash('flash_message', 'Detail Soal dengan id ' . $soalId . ' tidak ditemukan');
                return Redirect::back(); 
            }

            return view('admin.dashboard.soal_quiz.show')
                ->with('soal', $JawabanSoal)
                ->with('userjawablembar', $userJawabLembar)
                ->with('is_last_soal', $isLastSoal)
                ->with('next_soal', $nextSoal)
                ->with('nomor', $nomor)
                ->with('all_soal_ids', $AllsoalIds) // ganti jumlah soal sekarang
                ->with('max_time', date('Y/m/d H:i:s', $maxTime));

        } catch (Exception $e) {
            return Redirect::action('Admin\QuizController@show', array($userJawabLembar->id_quiz))->with('messages',
                array(
                    array('error', $e->getMessage())
                ));

        }
    }


public function update(Request $request, $userjawablembarId, $soalId)
    {       

      //check time
      //update user jawab
      //update score
      //go to next soal
      try {
          DB::beginTransaction();
          $userJawabLembar = NilaiQuizPilihanGanda::find($userjawablembarId);
          
          $id_user_trainee = Trainee::where('nik_trainee', $userJawabLembar->nik_trainee)->first()->id_user;

          $quiz = Quiz::find($userJawabLembar->id_quiz);
          $waktu_quiz = $quiz->waktu_quiz;

          if (!$userJawabLembar){
                Session::flash('flash_message', 'Quiz tidak ditemukan');
                return Redirect::back(); 
            }              

          if (Auth::user()->id_user != $id_user_trainee){
                Session::flash('flash_message', 'Quiz ini bukan untuk anda');
                return Redirect::back(); 
            }

          //populate soal id
          $userJawabBelum = TraineeJawabQuizPilihanGanda::whereRaw('id_nilai_quiz_pilgan = ? and id_jawaban_soal_quiz is null', array($userJawabLembar->id_nilai_quiz_pilgan));
          $soalIds        = $userJawabBelum->pluck('id_soal')->toArray();

          if (!in_array($soalId, $soalIds)){
                Session::flash('flash_message', 'Soal bukan termasuk dalam quiz atau sudah anda kerjakan');
                return Redirect::back(); 
            }

          if (!$request->input('jawaban'))
              return Redirect::action('Admin\SoalQuizController@show', array($userJawabLembar->id_nilai_quiz_pilgan, $soalId))->with('messages',
                  array(
                      array('error', 'Silakan pilih jawaban atau tekan tombol LEWATI untuk melewati soal ini')
                  ));

          //soal sudah terjawab semua
          $isLastSoal = false;
          if (sizeof($soalIds) == 1 && $soalId == $soalIds[0])
              $isLastSoal = true;

          $nextSoal = false;
          if (!$isLastSoal) {
              //get next soal
              //adalah soal terakhir
              $currentKey = array_keys($soalIds, $soalId);
              $currentKey = $currentKey[0];
              if ($soalIds[count($soalIds) - 1] == $soalId) {
                  //find sebelumnya
                  $nextSoal = $soalIds[0];
              } else {
                  $nextSoal = $soalIds[$currentKey + 1];
              }
          }

          $startTime = strtotime($userJawabLembar->wkt_mulai);
          $maxTime   = strtotime('+' . $waktu_quiz . ' minutes', $startTime);

          if ($userJawabLembar->wkt_selesai){
                Session::flash('flash_message', 'Anda sudah menyelesaikan Quiz ini');
                return Redirect::back(); 
            }

          //check waktu
          if (time() > $maxTime) {
              //update waktu selesai jika diperlukan
              if (!$userJawabLembar->wkt_selesai) {
                  $userJawabLembar->wkt_selesai = date('Y-m-d H:i:s');
                  $userJawabLembar->save();
              }
                Session::flash('flash_message', 'Waktu mengerjakan sudah habis');
                return Redirect::back(); 
          }

          if ($startTime > time()){
                Session::flash('flash_message', 'Waktu mengerjakan belum dimulai');
                return Redirect::back(); 
            }
    
          $soal = Soal::find($soalId);

          if (!$soal){
                Session::flash('flash_message', 'Detail Soal dengan id ' . $soalId . ' tidak ditemukan');
                return Redirect::back(); 
            }
          $jawaban = $request->input('jawaban');          
          $id_jawaban_soal_quiz = Jawaban::where('id_soal', $soalId)->get();
          // dd($id_jawaban_soal_quiz->pluck('id_jawaban_soal_quiz')->toArray());
          // dd($jawaban);
          if (!in_array($jawaban, $id_jawaban_soal_quiz->pluck('id_jawaban_soal_quiz')->toArray())){
                Session::flash('flash_message', 'Jawaban tidak ada dalam sistem');
                return Redirect::back(); 
            }
// dd('jawaban', $request->all());
          $userJawab = TraineeJawabQuizPilihanGanda::whereRaw('id_nilai_quiz_pilgan = ? and id_soal = ? and id_jawaban_soal_quiz is null', array($userJawabLembar->id_nilai_quiz_pilgan, $soal->id_soal))->first();
          if (!$userJawab){
                Session::flash('flash_message', 'Soal bukan termasuk dalam quiz anda atau sudah anda kerjakan');
                return Redirect::back(); 
            }


          $userJawab->id_jawaban_soal_quiz = $jawaban;
          $userJawab->save();

          //check score
          $userJawabLembar->calcScore();
          // dd($userJawabLembar);
          $userJawabLembar->save();

          DB::commit();

          if (!$isLastSoal)
              return Redirect::action('Admin\SoalQuizController@show', array($userJawabLembar->id_nilai_quiz_pilgan, $nextSoal));
              $userJawabLembar->wkt_selesai = date('Y-m-d H:i:s');
              $userJawabLembar->save();

          return Redirect::action('Admin\QuizController@show', array($userJawabLembar->id_nilai_quiz_pilgan));

      } catch (Exception $e) {
          DB::rollback();
          return Redirect::action('Admin\QuizController@show', array($userJawabLembar->id_nilai_quiz_pilgan))->with('messages',
              array(
                  array('error', $e->getMessage())
              ));

      }
  } 
}

