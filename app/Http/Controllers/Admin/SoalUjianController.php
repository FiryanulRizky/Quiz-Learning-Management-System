<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use DB;
use Auth;

use Validator;
use App\Http\Controllers\Controller;
use App\Ujian as Ujian;
use App\Soal as Soal;
use App\Trainee as Trainee;
use App\Trainer as Trainer;
use App\SoalHasUjian as SoalHasUjian;
use App\Modul as Modul;
use App\JawabanSoalUjian as Jawaban;
use App\TraineeJawabUjianPilihanGanda as TraineeJawabUjianPilihanGanda;
use App\NilaiUjianPilihanGandaTrainee as NilaiUjianPilihanGanda;
use Session;

class SoalUjianController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function detail($id_soal)
  { 
      $dataSoal = Soal::find($id_soal);         
      $JawabanSoal = DB::table('jawaban_soal_ujians')       
            ->join('soals','jawaban_soal_ujians.id_soal','=','soals.id_soal')       
            ->where('jawaban_soal_ujians.id_soal', $id_soal)
            ->select('jawaban_soal_ujians.*', 'soals.*') 
            ->get();

      $soal_ujian = Soal::orderBy('id_soal')->get();   
      $dataUjian = DB::table('soals')   
         ->join('ujians','soals.id_ujian','=','ujians.id_ujian')
         ->where('soals.id_soal', $id_soal)
         ->select('ujians.*', 'soals.*')
         ->get();     
         // dd($JawabanSoal[0]->id_soal);
         // dd($dataSoal);         
      return view('admin.dashboard.soal_ujian.detail_soal',$dataSoal)                
             ->with('ujian', $dataUjian)              
             ->with('soal', $JawabanSoal); 
  }

  public function showTambahSoalUjian()
  {
    if (Auth::user()->level == 11) {     
      $dataUjian = DB::table('ujians')   
           ->join('moduls','ujians.id_modul','=','moduls.id_modul')
           ->select('ujians.*', 'moduls.nama_modul')
           ->get();   
    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
      $dataUjian = DB::table('ujians')   
           ->join('moduls','ujians.id_modul','=','moduls.id_modul')
           ->select('ujians.*', 'moduls.nama_modul')
           ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
           ->get();      
    }     
    $data = array('ujian' => $dataUjian);        
    return view('admin.dashboard.soal_ujian.tambah_soal_ujian',$data);         
  }

public function index()
  { 
    $countSoalPilgan   = Soal::where('jenis_soal', '=', 'Pilihan Ganda')->count(); 
    $countSoalEssay   = Soal::where('jenis_soal', '=', 'Essay')->count();     
    
    if (Auth::user()->level == 11) {
      $dataSoalUjian = DB::table('soals')   
               ->join('ujians', 'soals.id_ujian', '=', 'ujians.id_ujian') 
               ->leftjoin('moduls','ujians.id_modul','=','moduls.id_modul')
               ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
               ->select('soals.*', 'ujians.*', 'moduls.nama_modul', 'trainers.nama_trainer')
               ->get();             
    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
      $dataSoalUjian = DB::table('soals')   
               ->join('ujians', 'soals.id_ujian', '=', 'ujians.id_ujian') 
               ->leftjoin('moduls','ujians.id_modul','=','moduls.id_modul')
               ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
               ->select('soals.*', 'ujians.*', 'moduls.nama_modul', 'trainers.nama_trainer')
               ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
               ->get();      
    }

    $dataJawabanSoal = DB::table('jawaban_soal_ujians')         
         ->join('soals','jawaban_soal_ujians.id_soal','=','soals.id_soal')
         ->leftjoin('ujians', 'soals.id_ujian', '=', 'ujians.id_ujian')
         ->select('jawaban_soal_ujians.poin', 'jawaban_soal_ujians.id_soal')
         ->get();
    
    $data = array('soal_ujian' => $dataSoalUjian);   
    $maxPoint = 0;
    foreach ($dataJawabanSoal as $jawaban)
        if ($jawaban->poin > $maxPoint)
            (int)$maxPoint = $jawaban->poin;
    // return $maxPoint;
    // dd($maxPoint);            
    return view('admin.dashboard.soal_ujian.soal_ujian',$data)
            ->with('countSoalPilgan', $countSoalPilgan)
            ->with('countSoalEssay', $countSoalEssay)
            ->with('poin', $maxPoint);
  }    

public function hapus($id_soal)
  {   
    $id_soal = Soal::where('id_soal', '=', $id_soal)->first();
    if ($id_soal == null)
      app::abort(404);    
    Session::flash('flash_message', 'Data Soal Ujian "'.$id_soal->jenis_soal.'" - "'.$id_soal->no_soal.'" Berhasil dihapus.');
    $id_soal->delete();    
    if (Auth::user()->level == 11) {
      return redirect('admin/ujian/'.$id_soal->id_ujian.'/detail');
    }elseif (Auth::user()->level == 12) {
      return redirect('trainer/ujian/'.$id_soal->id_ujian.'/detail');
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
          'id_ujian.required'  => 'ID Modul dibutuhkan.', );
      $aturan_essay_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'gambar'      => 'required',
          'id_ujian'      => 'required', );
      $pesan_pilgan_gbr = array(
          'jenis_soal.required' => 'Jenis Soal dibutuhkan.', 
          'pertanyaan.required' => 'Pertanyaan dibutuhkan.',             
          'gambar.required'     => 'Gambar dibutuhkan.', 
          'id_ujian.required'  => 'ID Modul dibutuhkan.', 
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
          'id_ujian'      => 'required', 
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
          'id_ujian.required'  => 'ID Modul dibutuhkan.', 
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
          'id_ujian'      => 'required', 
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
          'id_ujian.required'  => 'ID Modul dibutuhkan.',             
        );
      $aturan_essay_no_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'id_ujian'      => 'required',             
        );

         if ($jenis_soal == 'Essay') {
          if (!empty($gambar)) {                  
            // dd($pesan_essay_gbr, $aturan_essay_gbr);  
            // dd($jenis_soal, $gambar);    
            $validator = Validator::make($input,$aturan_essay_gbr, $pesan_essay_gbr);
            if($validator->fails())
              # Kembali kehalaman yang sama dengan pesan error
                return Redirect::back()->withErrors($validator)->withInput();
            $soal_ujian->gambar       = $request['gambar'];
            
            $gambar = $request->file('gambar');         
            $namaGambar = $gambar->getClientOriginalName();
            $request->file('gambar')->move('upload_gambar', $namaGambar);
            
            # Bila validasi sukses
            $soal_ujian = new Soal;
            $soal_ujian->jenis_soal     = $request['jenis_soal'];        
            $soal_ujian->pertanyaan     = $request['pertanyaan'];        
            $soal_ujian->gambar         = $namaGambar; //$request['gambar'];        
            $soal_ujian->id_ujian       = $request['id_ujian'];                                  
            //melakukan save, jika gagal (return value false) lakukan harakiri
            //error kode 500 - internal server error
            if (! $soal_ujian->save() )
              App::abort(500);
            Session::flash('flash_message', 'Data Soal Ujian "'.$request['jenis_soal'].'" Berhasil disimpan.');
                if (Auth::user()->level == 11) {
                  return redirect('admin/ujian/'.$request['id_ujian'].'/detail');
                }elseif (Auth::user()->level == 12) {
                  return redirect('trainer/ujian/'.$request['id_ujian'].'/detail');
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
            $soal_ujian = new Soal;
            $soal_ujian->jenis_soal     = $request['jenis_soal'];        
            $soal_ujian->pertanyaan     = $request['pertanyaan'];               
            $soal_ujian->id_ujian       = $request['id_ujian'];                                  
            //melakukan save, jika gagal (return value false) lakukan harakiri
            //error kode 500 - internal server error
            if (! $soal_ujian->save() )
              App::abort(500);
            Session::flash('flash_message', 'Data Soal Ujian "'.$request['jenis_soal'].'" Berhasil disimpan.');
                if (Auth::user()->level == 11) {
                  return redirect('admin/ujian/'.$request['id_ujian'].'/detail');
                }elseif (Auth::user()->level == 12) {
                  return redirect('trainer/ujian/'.$request['id_ujian'].'/detail');
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

                $soal_ujian = new Soal;
                $soal_ujian->jenis_soal     = $request['jenis_soal'];        
                $soal_ujian->pertanyaan     = $request['pertanyaan'];
                $soal_ujian->gambar         = $namaGambar; //$request['gambar'];                  
                $soal_ujian->id_ujian       = $request['id_ujian'];                                 
                if (! $soal_ujian->save() )
                  throw new Exception('Gagal Menyimpan Soal');

                /// buat sol_has_ujian
                $soal_has_ujian = new SoalHasUjian();
                $soal_has_ujian->id_soal = $soal_ujian->id_soal;
                $soal_has_ujian->id_ujian = $soal_ujian->id_ujian;
                if (! $soal_has_ujian->save())
                  throw new Exception('Gagal Menyimpan Soal Has Ujian');

                // Buat Jawaban
                $jawaban1 = new Jawaban();// create baru jawaban a                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_A"
                $jawaban1->jawaban  = $request->input('Jawaban_A');
                $jawaban1->is_benar = $request->input('a_is_benar');
                $jawaban1->poin     = $request->input('Point_Jawaban_A');
                $jawaban1->id_soal  = $soal_ujian->id_soal;
                if (!$jawaban1->save())
                    throw new Exception('Gagal Menyimpan Jawaban A');
                
                $jawaban2 = new Jawaban();// create baru jawaban b                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_B"
                $jawaban2->jawaban  = $request->input('Jawaban_B');
                $jawaban2->is_benar = $request->input('b_is_benar');
                $jawaban2->poin     = $request->input('Point_Jawaban_B');
                $jawaban2->id_soal  = $soal_ujian->id_soal;
                if (!$jawaban2->save())
                    throw new Exception('Gagal Menyimpan Jawaban B');
                
                $jawaban3 = new Jawaban();// create baru jawaban c                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_C"
                $jawaban3->jawaban  = $request->input('Jawaban_C');
                $jawaban3->is_benar = $request->input('c_is_benar');
                $jawaban3->poin     = $request->input('Point_Jawaban_C');
                $jawaban3->id_soal  = $soal_ujian->id_soal;
                if (!$jawaban3->save())
                    throw new Exception('Gagal Menyimpan Jawaban C');
                
                $jawaban4 = new Jawaban();// create baru jawaban d                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_D"
                $jawaban4->jawaban  = $request->input('Jawaban_D');
                $jawaban4->is_benar = $request->input('d_is_benar');
                $jawaban4->poin     = $request->input('Point_Jawaban_D');
                $jawaban4->id_soal  = $soal_ujian->id_soal;
                if (!$jawaban4->save())
                    throw new Exception('Gagal Menyimpan Jawaban D');

                Session::flash('flash_message', 'Data Soal Ujian "'.$request['jenis_soal'].'" Berhasil disimpan.');
                if (Auth::user()->level == 11) {
                  return redirect('admin/ujian/'.$request['id_ujian'].'/detail');
                }elseif (Auth::user()->level == 12) {
                  return redirect('trainer/ujian/'.$request['id_ujian'].'/detail');
                }                           
          }
          
            // dd($pesan_pilgan_no_gbr, $aturan_pilgan_no_gbr); 
            // dd($jenis_soal);
          $validator = Validator::make($input,$aturan_pilgan_no_gbr, $pesan_pilgan_no_gbr);
            if($validator->fails())
              # Kembali kehalaman yang sama dengan pesan error
                return Redirect::back()->withErrors($validator)->withInput();                             
                # Bila validasi sukses
                $soal_ujian = new Soal;
                $soal_ujian->jenis_soal     = $request['jenis_soal'];        
                $soal_ujian->pertanyaan     = $request['pertanyaan'];                                
                $soal_ujian->id_ujian       = $request['id_ujian'];                                 
                if (! $soal_ujian->save() )
                  throw new Exception('Gagal Menyimpan Soal');

                /// buat sol_has_ujian
                $soal_has_ujian = new SoalHasUjian();
                $soal_has_ujian->id_soal = $soal_ujian->id_soal;
                $soal_has_ujian->id_ujian = $soal_ujian->id_ujian;
                if (! $soal_has_ujian->save())
                  throw new Exception('Gagal Menyimpan Soal Has Ujian');
                
                $jawaban1 = new Jawaban();// create baru jawaban a                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_A"
                $jawaban1->jawaban  = $request->input('Jawaban_A');
                $jawaban1->is_benar = $request->input('a_is_benar');
                $jawaban1->poin     = $request->input('Point_Jawaban_A');
                $jawaban1->id_soal  = $soal_ujian->id_soal;
                if (!$jawaban1->save())
                    throw new Exception('Gagal Menyimpan Jawaban A');
                
                $jawaban2 = new Jawaban();// create baru jawaban b                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_B"
                $jawaban2->jawaban  = $request->input('Jawaban_B');
                $jawaban2->is_benar = $request->input('b_is_benar');
                $jawaban2->poin     = $request->input('Point_Jawaban_B');
                $jawaban2->id_soal  = $soal_ujian->id_soal;
                if (!$jawaban2->save())
                    throw new Exception('Gagal Menyimpan Jawaban B');
                
                $jawaban3 = new Jawaban();// create baru jawaban c                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_C"
                $jawaban3->jawaban  = $request->input('Jawaban_C');
                $jawaban3->is_benar = $request->input('c_is_benar');
                $jawaban3->poin     = $request->input('Point_Jawaban_C');
                $jawaban3->id_soal  = $soal_ujian->id_soal;
                if (!$jawaban3->save())
                    throw new Exception('Gagal Menyimpan Jawaban C');
                
                $jawaban4 = new Jawaban();// create baru jawaban d                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_D"
                $jawaban4->jawaban  = $request->input('Jawaban_D');
                $jawaban4->is_benar = $request->input('d_is_benar');
                $jawaban4->poin     = $request->input('Point_Jawaban_D');
                $jawaban4->id_soal  = $soal_ujian->id_soal;
                if (!$jawaban4->save())
                    throw new Exception('Gagal Menyimpan Jawaban D');
                  
                Session::flash('flash_message', 'Data Soal Ujian "'.$request['jenis_soal'].'" Berhasil disimpan.');
                if (Auth::user()->level == 11) {
                  return redirect('admin/ujian/'.$request['id_ujian'].'/detail');
                }elseif (Auth::user()->level == 12) {
                  return redirect('trainer/ujian/'.$request['id_ujian'].'/detail');
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
        $JawabanSoal = DB::table('jawaban_soal_ujians')              
              ->where('jawaban_soal_ujians.id_soal', $id_soal)
              ->select('jawaban_soal_ujians.*') 
              ->get(); 
        if (Auth::user()->level == 11) {     
        $dataUjian = DB::table('ujians')   
               ->join('moduls','ujians.id_modul','=','moduls.id_modul')
               ->select('ujians.*', 'moduls.nama_modul')
               ->get();   
        }elseif (Auth::user()->level == 12) {
          $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
          $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
          $dataUjian = DB::table('ujians')   
               ->join('moduls','ujians.id_modul','=','moduls.id_modul')
               ->select('ujians.*', 'moduls.nama_modul')
               ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
               ->get();      
        }    

        return view('admin.dashboard.soal_ujian.edit_soal_ujian',$dataSoal)                
               ->with('ujian', $dataUjian)              
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
          'id_ujian.required'  => 'ID Modul dibutuhkan.', );
      $aturan_essay_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'gambar'      => 'required',
          'id_ujian'      => 'required', );
      $pesan_pilgan_gbr = array(
          'jenis_soal.required' => 'Jenis Soal dibutuhkan.', 
          'pertanyaan.required' => 'Pertanyaan dibutuhkan.',             
          'gambar.required'     => 'Gambar dibutuhkan.', 
          'id_ujian.required'  => 'ID Modul dibutuhkan.', 
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
          'id_ujian'      => 'required', 
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
          'id_ujian.required'  => 'ID Modul dibutuhkan.', 
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
          'id_ujian'      => 'required', 
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
          'id_ujian.required'  => 'ID Modul dibutuhkan.',             
        );
      $aturan_essay_no_gbr = array(
          'jenis_soal'   => 'required',
          'pertanyaan'    => 'required',            
          'id_ujian'      => 'required',             
        );

         if ($jenis_soal == 'Essay') {
          if (!empty($gambar)) {                                
            $validator = Validator::make($input,$aturan_essay_gbr, $pesan_essay_gbr);
            if($validator->fails())              
                return Redirect::back()->withErrors($validator)->withInput();
            # Bila validasi sukses
            $SoalUjian = Soal::findOrFail($id_soal);
            $gambar = $input['gambar'];         
            $namaGambar = $gambar->getClientOriginalName();            
            
            if (!$SoalUjian->gambar == "") {
              // hapus gambar lama
              $image_path = public_path().'/upload_gambar/'.$SoalUjian->gambar;
              unlink($image_path);
            }
            // upload gambar baru
            $input['gambar']->move('upload_gambar', $namaGambar);
            
            $editSoalUjian = Soal::find($id_soal);
            $editSoalUjian->jenis_soal     = $input['jenis_soal'];        
            $editSoalUjian->pertanyaan     = $input['pertanyaan'];        
            $soal_ujian->gambar            = $namaGambar; //$request['gambar'];        
            $editSoalUjian->id_ujian       = $input['id_ujian'];                                  
            if (! $editSoalUjian->save() )
              App::abort(500);
            Session::flash('flash_message', 'Data Soal Ujian "'.$input['jenis_soal'].'" Berhasil disimpan.');            
            if (Auth::user()->level == 11) {
              return redirect('admin/soal_ujian/');
            }elseif (Auth::user()->level == 12) {
              return redirect('trainer/soal_ujian/');
            }                   
          }                      
            // dd($pesan_essay_no_gbr, $aturan_essay_no_gbr); 
            // dd($jenis_soal); 
            $validator = Validator::make($input,$aturan_essay_no_gbr, $pesan_essay_no_gbr);
            if($validator->fails()){
              # Kembali kehalaman yang sama dengan pesan error
                return Redirect::back()->withErrors($validator)->withInput();
              } 

            $editSoalUjian = Soal::find($id_soal);
            $editSoalUjian->jenis_soal     = $input['jenis_soal'];        
            $editSoalUjian->pertanyaan     = $input['pertanyaan'];               
            $editSoalUjian->id_ujian       = $input['id_ujian'];                                  
            
            if (! $editSoalUjian->save() )
              App::abort(500);
            Session::flash('flash_message', 'Data Soal Ujian "'.$input['jenis_soal'].'" Berhasil disimpan.');
            if (Auth::user()->level == 11) {
              return redirect('admin/soal_ujian/');
            }elseif (Auth::user()->level == 12) {
              return redirect('trainer/soal_ujian/');
            }                             
         }
         elseif ($jenis_soal == 'Pilihan Ganda') {
          if (!empty($gambar)) { 

            $validator = Validator::make($input,$aturan_pilgan_gbr, $pesan_pilgan_gbr);
            if($validator->fails())              
                return Redirect::back()->withErrors($validator)->withInput();              
            
                $SoalUjian = Soal::findOrFail($id_soal);
                $gambar = $request->file('gambar');        
                $namaGambar = $gambar->getClientOriginalName();

                if (!$SoalUjian->gambar == "") {
                  // hapus file lama
                  $image_path = public_path().'/upload_gambar/'.$SoalUjian->gambar;
                  unlink($image_path);
                }
                
                // upload file baru
                $request->file('gambar')->move('upload_gambar', $namaGambar);
                // $input['gambar']->move('upload_gambar', $namaGambar);
              
                $editSoalUjian = Soal::find($id_soal);
                $editSoalUjian->jenis_soal     = $input['jenis_soal'];        
                $editSoalUjian->pertanyaan     = $input['pertanyaan'];
                $editSoalUjian->gambar            = $namaGambar; //$request['gambar'];                                                 
                $editSoalUjian->id_ujian       = $input['id_ujian'];                                 
                if (! $editSoalUjian->save() )
                  throw new Exception('Gagal Menyimpan Soal');

                /// buat sol_has_ujian
                $soal_has_ujian = new SoalHasUjian();
                $soal_has_ujian->id_soal = $editSoalUjian->id_soal;
                $soal_has_ujian->id_ujian = $editSoalUjian->id_ujian;
                if (! $soal_has_ujian->save())
                  throw new Exception('Gagal Menyimpan Soal Has Ujian');
                
                $jawaban1 = $jawaban[0];// create baru jawaban a                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_A"
                $jawaban1->jawaban  = $request->input('Jawaban_A');
                $jawaban1->is_benar = $request->input('a_is_benar');
                $jawaban1->poin     = $request->input('Point_Jawaban_A');
                $jawaban1->id_soal  = $editSoalUjian->id_soal;
                if (!$jawaban1->save())
                    throw new Exception('Gagal Menyimpan Jawaban A');
                
                $jawaban2 = $jawaban[1];// create baru jawaban b                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_B"
                $jawaban2->jawaban  = $request->input('Jawaban_B');
                $jawaban2->is_benar = $request->input('b_is_benar');
                $jawaban2->poin     = $request->input('Point_Jawaban_B');
                $jawaban2->id_soal  = $editSoalUjian->id_soal;
                if (!$jawaban2->save())
                    throw new Exception('Gagal Menyimpan Jawaban B');
                
                $jawaban3 = $jawaban[2];// create baru jawaban c                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_C"
                $jawaban3->jawaban  = $request->input('Jawaban_C');
                $jawaban3->is_benar = $request->input('c_is_benar');
                $jawaban3->poin     = $request->input('Point_Jawaban_C');
                $jawaban3->id_soal  = $editSoalUjian->id_soal;
                if (!$jawaban3->save())
                    throw new Exception('Gagal Menyimpan Jawaban C');
                
                $jawaban4 = $jawaban[3];// create baru jawaban d                
                // save kiriman form untuk tabel "jawaban index ke 0 sebagai Jawaban_D"
                $jawaban4->jawaban  = $request->input('Jawaban_D');
                $jawaban4->is_benar = $request->input('d_is_benar');
                $jawaban4->poin     = $request->input('Point_Jawaban_D');
                $jawaban4->id_soal  = $editSoalUjian->id_soal;
                if (!$jawaban4->save())
                    throw new Exception('Gagal Menyimpan Jawaban D');

                Session::flash('flash_message', 'Data Soal Ujian "'.$input['jenis_soal'].'" Berhasil disimpan.');
                if (Auth::user()->level == 11) {
                  return redirect('admin/soal_ujian/');
                }elseif (Auth::user()->level == 12) {
                  return redirect('trainer/soal_ujian/');
                }
          }
          
          $validator = Validator::make($input,$aturan_pilgan_no_gbr, $pesan_pilgan_no_gbr);
            if($validator->fails())
              
                return Redirect::back()->withErrors($validator)->withInput();                             
                $editSoalUjian = Soal::find($id_soal);
                $editSoalUjian->jenis_soal     = $input['jenis_soal'];        
                $editSoalUjian->pertanyaan     = $input['pertanyaan'];
                $editSoalUjian->id_ujian       = $input['id_ujian'];                                 
                if (! $editSoalUjian->save() )
                  throw new Exception('Gagal Menyimpan Soal');

                /// buat sol_has_ujian
                $soal_has_ujian = new SoalHasUjian();
                $soal_has_ujian->id_soal = $editSoalUjian->id_soal;
                $soal_has_ujian->id_ujian = $editSoalUjian->id_ujian;
                if (! $soal_has_ujian->save())
                  throw new Exception('Gagal Menyimpan Soal Has Ujian');
                
                $jawaban1 = $jawaban[0]; 
                $jawaban1->jawaban  = $request->input('Jawaban_A');
                $jawaban1->is_benar = $request->input('a_is_benar');
                $jawaban1->poin     = $request->input('Point_Jawaban_A');
                $jawaban1->id_soal  = $editSoalUjian->id_soal;
                // dd($jawaban1);

                if (! $jawaban1->save() )
                    throw new Exception('Gagal Menyimpan Jawaban A');
                
                $jawaban2 = $jawaban[1]; 
                $jawaban2->jawaban  = $request->input('Jawaban_B');
                $jawaban2->is_benar = $request->input('b_is_benar');
                $jawaban2->poin     = $request->input('Point_Jawaban_B');
                $jawaban2->id_soal  = $editSoalUjian->id_soal;
                if (!$jawaban2->save())
                    throw new Exception('Gagal Menyimpan Jawaban B');
                
                $jawaban3 = $jawaban[2]; 
                $jawaban3->jawaban  = $request->input('Jawaban_C');
                $jawaban3->is_benar = $request->input('c_is_benar');
                $jawaban3->poin     = $request->input('Point_Jawaban_C');
                $jawaban3->id_soal  = $editSoalUjian->id_soal;
                if (!$jawaban3->save())
                    throw new Exception('Gagal Menyimpan Jawaban C');
                
                $jawaban4 = $jawaban[3];                         
                $jawaban4->jawaban  = $request->input('Jawaban_D');
                $jawaban4->is_benar = $request->input('d_is_benar');
                $jawaban4->poin     = $request->input('Point_Jawaban_D');
                $jawaban4->id_soal  = $editSoalUjian->id_soal;
          
                if (!$jawaban4->save())
                    throw new Exception('Gagal Menyimpan Jawaban D');
                  
          Session::flash('flash_message', 'Data Soal Ujian "'.$input['jenis_soal'].'" Berhasil diubah.');
          if (Auth::user()->level == 11) {
            return redirect('admin/ujian/'.$editSoalUjian->id_ujian.'/detail');
            // return Redirect::back();
            // return Redirect::back();
          }elseif (Auth::user()->level == 12) {
            return redirect('trainer/ujian/'.$editSoalUjian->id_ujian.'/detail');
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
            $userJawabLembar = NilaiUjianPilihanGanda::find($userjawablembarId);                                   
            $id_user_trainee = Trainee::where('nisn_trainee', $userJawabLembar->nisn_trainee)->first()->id_user;                       

            if (!$userJawabLembar){
                Session::flash('flash_message', 'Ujian tidak ditemukan');
                return Redirect::back(); 
            }
            // cek apakah sama id_user trainee dengan id_user trainee yang akan start ujian.
            if (Auth::user()->id_user != $id_user_trainee){
                Session::flash('flash_message', 'Ujian ini bukan untuk anda');
                return Redirect::back(); 
            }

            //populate soal id
            $userJawabBelum = TraineeJawabUjianPilihanGanda::whereRaw('id_nilai_ujian_pilgan = ? and id_jawaban_soal_ujian is null', array($userJawabLembar->id_nilai_ujian_pilgan));
            $userJawabAll   = TraineeJawabUjianPilihanGanda::whereRaw('id_nilai_ujian_pilgan = ?', array($userJawabLembar->id_nilai_ujian_pilgan));            
            $soalIds        = $userJawabBelum->pluck('id_soal')->toArray();
            $AllsoalIds     = $userJawabAll->pluck('id_soal')->toArray();                        

            if (!$soalId)
                return Redirect::action('Admin\SoalUjianController@show', array($userJawabLembar->id_nilai_ujian_pilgan, $soalIds[0]));

            if (!in_array($soalId, $soalIds))
                throw new \Exception('Soal bukan termasuk dalam ujian');
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
            
            $ujian = Ujian::find($userJawabLembar->id_ujian);
            $waktu_ujian = $ujian->waktu_ujian;

            $startTime = strtotime($userJawabLembar->wkt_mulai);
            $maxTime   = strtotime('+' . $waktu_ujian . ' minutes', $startTime);

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

            $JawabanSoal = DB::table('jawaban_soal_ujians')       
                        ->join('soals','jawaban_soal_ujians.id_soal','=','soals.id_soal')       
                        ->where('jawaban_soal_ujians.id_soal', $soalId)
                        ->select('jawaban_soal_ujians.*', 'soals.*') 
                        ->get();

            if (!$JawabanSoal){
                Session::flash('flash_message', 'Detail Soal dengan id ' . $soalId . ' tidak ditemukan');
                return Redirect::back(); 
            }

            return view('admin.dashboard.soal_ujian.show')
                ->with('soal', $JawabanSoal)
                ->with('userjawablembar', $userJawabLembar)
                ->with('is_last_soal', $isLastSoal)
                ->with('next_soal', $nextSoal)
                ->with('nomor', $nomor)
                ->with('all_soal_ids', $AllsoalIds) // ganti jumlah soal sekarang
                ->with('max_time', date('Y/m/d H:i:s', $maxTime));

        } catch (Exception $e) {
            return Redirect::action('Admin\UjianController@show', array($userJawabLembar->id_ujian))->with('messages',
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
          $userJawabLembar = NilaiUjianPilihanGanda::find($userjawablembarId);
          
          $id_user_trainee = Trainee::where('nisn_trainee', $userJawabLembar->nisn_trainee)->first()->id_user;

          $ujian = Ujian::find($userJawabLembar->id_ujian);
          $waktu_ujian = $ujian->waktu_ujian;

          if (!$userJawabLembar){
                Session::flash('flash_message', 'Ujian tidak ditemukan');
                return Redirect::back(); 
            }              

          if (Auth::user()->id_user != $id_user_trainee){
                Session::flash('flash_message', 'Ujian ini bukan untuk anda');
                return Redirect::back(); 
            }

          //populate soal id
          $userJawabBelum = TraineeJawabUjianPilihanGanda::whereRaw('id_nilai_ujian_pilgan = ? and id_jawaban_soal_ujian is null', array($userJawabLembar->id_nilai_ujian_pilgan));
          $soalIds        = $userJawabBelum->pluck('id_soal')->toArray();

          if (!in_array($soalId, $soalIds)){
                Session::flash('flash_message', 'Soal bukan termasuk dalam ujian atau sudah anda kerjakan');
                return Redirect::back(); 
            }

          if (!$request->input('jawaban'))
              return Redirect::action('Admin\SoalUjianController@show', array($userJawabLembar->id_nilai_ujian_pilgan, $soalId))->with('messages',
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
          $maxTime   = strtotime('+' . $waktu_ujian . ' minutes', $startTime);

          if ($userJawabLembar->wkt_selesai){
                Session::flash('flash_message', 'Anda sudah menyelesaikan Ujian ini');
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
          $id_jawaban_soal_ujian = Jawaban::where('id_soal', $soalId)->get();
          // dd($id_jawaban_soal_ujian->pluck('id_jawaban_soal_ujian')->toArray());
          // dd($jawaban);
          if (!in_array($jawaban, $id_jawaban_soal_ujian->pluck('id_jawaban_soal_ujian')->toArray())){
                Session::flash('flash_message', 'Jawaban tidak ada dalam sistem');
                return Redirect::back(); 
            }
// dd('jawaban', $request->all());
          $userJawab = TraineeJawabUjianPilihanGanda::whereRaw('id_nilai_ujian_pilgan = ? and id_soal = ? and id_jawaban_soal_ujian is null', array($userJawabLembar->id_nilai_ujian_pilgan, $soal->id_soal))->first();
          if (!$userJawab){
                Session::flash('flash_message', 'Soal bukan termasuk dalam ujian anda atau sudah anda kerjakan');
                return Redirect::back(); 
            }


          $userJawab->id_jawaban_soal_ujian = $jawaban;
          $userJawab->save();

          //check score
          $userJawabLembar->calcScore();
          // dd($userJawabLembar);
          $userJawabLembar->save();

          DB::commit();

          if (!$isLastSoal)
              return Redirect::action('Admin\SoalUjianController@show', array($userJawabLembar->id_nilai_ujian_pilgan, $nextSoal));
              $userJawabLembar->wkt_selesai = date('Y-m-d H:i:s');
              $userJawabLembar->save();

          return Redirect::action('Admin\UjianController@show', array($userJawabLembar->id_nilai_ujian_pilgan));

      } catch (Exception $e) {
          DB::rollback();
          return Redirect::action('Admin\UjianController@show', array($userJawabLembar->id_nilai_ujian_pilgan))->with('messages',
              array(
                  array('error', $e->getMessage())
              ));

      }
  } 
}

