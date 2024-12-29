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
use App\Modul as Modul;
use App\TraineeJawabQuizPilihanGanda as TraineeJawabQuizPilihanGanda;
use App\NilaiQuizPilihanGandaTrainee as NilaiQuizPilihanGandaTrainee;
use App\JawabanSoalQuiz as JawabanSoalQuiz;
use App\SoalHasQuiz as SoalHasQuiz;
use Session;

class QuizController extends Controller
{
public function __construct()
  {
    $this->middleware('auth');
  }

public function showTambahQuiz()
  {
    if (Auth::user()->level == 11) {
     $Modul_learn= Modul::select(DB::raw("id_modul, nama_modul"))
        ->orderBy(DB::raw("id_modul"))
        ->get();

    return view('admin.dashboard.quiz.tambah_quiz')
        ->with('Modul_learn', $Modul_learn);

    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
      $dataDepartemen = DB::table('departemen_have_moduls')
                 ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                 ->select('departemen_have_moduls.*', 'moduls.nama_modul')
                 ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                 ->orderBy('departemen_have_moduls.nama_departemen', 'asc')->get();
      return view('admin.dashboard.quiz.tambah_quiz')
        ->with('dataModul_learn', $Modul_learnTrainer)
        ->with('dataDepartemen', $dataDepartemen);
    }
  }

public function detail($id_quiz)
  {
    $data = Quiz::find($id_quiz);
    $quiz = Quiz::orderBy('id_quiz')->get();
    $modul_quiz_datas = DB::table('quizs')
                 ->join('moduls', 'quizs.id_modul', '=', 'moduls.id_modul');
    
    $dataQuiz = $modul_quiz_datas
                 ->select('quizs.*')
                 ->where('quizs.id_quiz', $id_quiz)
                 ->first();
    $dataModul = $modul_quiz_datas
                 ->select('moduls.*')
                 ->where('quizs.id_quiz', $id_quiz)
                 ->get();

    // dd($dataQuiz);
    // revisi check waktu quiz
    $wkt_quiz  = $dataQuiz->tgl_quiz;
    $wkt_sekarang = Date('Y-m-d');
    if ($wkt_sekarang > $wkt_quiz) {
          Session::flash('flash_message', 'Batas akhir quiz Sudah Berakhir !!! Hubungi trainer anda.');
          return Redirect::back();
    }

    $dataSoalQuizDetail = DB::table('soals')
         ->join('quizs', 'soals.id_quiz', '=', 'quizs.id_quiz')
         ->leftjoin('moduls','quizs.id_modul','=','moduls.id_modul')
         ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
         ->select('soals.*', 'quizs.*', 'moduls.nama_modul', 'trainers.nama_trainer')
         ->where('soals.id_quiz', $id_quiz)
         ->get();

    $dataJawabanSoal = DB::table('jawaban_soal_quizs')
         ->join('soals','jawaban_soal_quizs.id_soal','=','soals.id_soal')
         ->leftjoin('quizs', 'soals.id_quiz', '=', 'quizs.id_quiz')
         ->select('jawaban_soal_quizs.poin', 'jawaban_soal_quizs.id_soal')
         ->get();

    $maxPoint = 0;
    foreach ($dataJawabanSoal as $jawaban){
        if ($jawaban->poin > $maxPoint)
            (int)$maxPoint = $jawaban->poin;
        }

    $countSoalPilgan   = Soal::where('jenis_soal', '=', 'Pilihan Ganda')->where('id_quiz', '=', $id_quiz)->count();
    $countSoalEssay   = Soal::where('jenis_soal', '=', 'Essay')->where('id_quiz', '=', $id_quiz)->count();
    $countSoalDetail   = Soal::where('id_quiz', '=', $id_quiz)->count();

    // dd($countSoalDetail);
    return view('admin.dashboard.quiz.detail_quiz', $data)
            ->with('countSoalPilgan', $countSoalPilgan)
            ->with('countSoalEssay', $countSoalEssay)
            ->with('countSoalDetail', $countSoalDetail)
            ->with('soal_quiz', $dataSoalQuizDetail)
            ->with('poin', $maxPoint)
            ->with('modul', $dataModul)
            ->with('quiz', $dataQuiz);
  }

public function index()
  {
    if (Auth::user()->level == 11) {
      $dataQuiz = DB::table('quizs')
                 ->join('moduls', 'quizs.id_modul', '=', 'moduls.id_modul')
                 ->select('quizs.*', 'moduls.nama_modul')
                 ->get();
    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
      $dataQuiz = DB::table('quizs')
                 ->join('moduls', 'quizs.id_modul', '=', 'moduls.id_modul')
                 ->select('quizs.*', 'moduls.nama_modul')
                 ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                 ->get();
    }
    $data = array('quiz' => $dataQuiz);
    return view('admin.dashboard.quiz.quiz',$data);
  }

  // daftar quiz trainee dan daftar pengambilan quiz trainee
public function index_trainee()
  {
    $id_user = Auth::user()->id_user;
    $trainee = Trainee::where('id_user',$id_user)->first();
    $nisn = $trainee->nik_trainee;

    $dataQuiz = DB::table('quizs')
                 ->join('moduls', 'quizs.id_modul', '=', 'moduls.id_modul')
                 ->select('quizs.*', 'moduls.nama_modul')
                 ->where('departemen_quiz', $trainee->departemen_trainee)
                 ->where('status_quiz', 'Aktif')
                 ->get();

    $data = array('quizTrainee' => $dataQuiz);

    $countQuizTrainee   = Quiz::where('departemen_quiz', $trainee->departemen_trainee)->get()->count(); // berdasarkan departemen nya trainee masing masing

    $userJawabLembar = NilaiQuizPilihanGandaTrainee::whereRaw('nik_trainee = ?', array($nisn))->orderBy('id_nilai_quiz_pilgan', 'desc')->get();
    $userJawabLembars = DB::table('nilai_quiz_pilgan_trainees')
                 ->join('quizs', 'nilai_quiz_pilgan_trainees.id_quiz', '=', 'quizs.id_quiz')
                 ->select('quizs.judul_quiz', 'quizs.jenis_quiz', 'quizs.tgl_quiz', 'nilai_quiz_pilgan_trainees.*')
                 ->whereRaw('nik_trainee = ?', array($nisn))->orderBy('id_nilai_quiz_pilgan', 'desc')->get();
    // new
    // $soals = Soal::orderBy('updated_at', 'desc')->get();

    return view('admin.dashboard.quiz.quiz',$data)
            ->with('trainee', $trainee)
            ->with('userJawabLembars', $userJawabLembar)
            ->with('countQuiz', $countQuizTrainee);
  }

public function hapus($id_quiz)
  {

    $id_quiz = Quiz::where('id_quiz', '=', $id_quiz)->first();
//dd($id_quiz);
    if ($id_quiz == null)
      \app::abort(404);

    Session::flash('flash_message', 'Data Quiz "'.$id_quiz->judul_quiz.'" - "'.$id_quiz->info_quiz.'" Berhasil dihapus.');

    $id_quiz->delete();

    if (Auth::user()->level == 11) {
      return redirect('admin/quiz/');
    }elseif (Auth::user()->level == 12) {
      return redirect('trainer/quiz/');
    }
  }

public function tambah(Request $request)
  {
        $input =$request->all();
        // revisi check waktu quiz
        $wkt_quiz  = $request['tgl_quiz'];
        $wkt_sekarang = Date('Y-m-d');
        if ($wkt_sekarang > $wkt_quiz) {
              Session::flash('flash_message', 'Tanggal quiz harus lebih dari waktu sekarang !!!');
              return Redirect::back();
        }

        $pesan = array(
        	'jenis_quiz.required' 		  => 'Jenis Quiz dibutuhkan.',
            'judul_quiz.required'      => 'Judul Quiz dibutuhkan.',
            'departemen_quiz.required'      => 'Departemen Quiz dibutuhkan.',
            'waktu_quiz.required'      => 'Batas Waktu Quiz dibutuhkan.',
            'jumlah_soal.required'            => 'Jumlah Soal dibutuhkan.',
            // 'is_random.required'        => ' dibutuhkan.',
            'pembuat_quiz.required'    => 'Pembuat Quiz dibutuhkan.',
            'tgl_quiz.required'        => 'Tanggal Quiz dibutuhkan.',
            'info_quiz.required'       => 'Info Quiz dibutuhkan.',
            'status_quiz.required'     => 'Status Quiz dibutuhkan.',
            'id_modul.required'         => 'ID Modul dibutuhkan.',

        );

        $aturan = array(
            'jenis_quiz'       => 'required',
            'judul_quiz'       => 'required',
            'departemen_quiz'       => 'required',
            'waktu_quiz'       => 'required|numeric|min:1',
            'jumlah_soal'       => 'required|numeric|min:1',
            // 'is_random'         => 'required',
            'pembuat_quiz'     => 'required',
            'tgl_quiz'         => 'required',
            'info_quiz'        => 'required',
            'status_quiz'      => 'required',
            'id_modul'          => 'required',

        );


        $validator = Validator::make($input,$aturan, $pesan);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses

        $quiz = new Quiz;
        $quiz->jenis_quiz       = $request['jenis_quiz'];
        $quiz->judul_quiz     	= $request['judul_quiz'];
        $quiz->departemen_quiz     	= $request['departemen_quiz'];
        $quiz->waktu_quiz     	= $request['waktu_quiz'];
        $quiz->jumlah_soal       = $request['jumlah_soal'];
        $quiz->is_random         = $request['is_random'];
        $quiz->pembuat_quiz     = $request['pembuat_quiz'];
        $quiz->tgl_quiz         = $request['tgl_quiz'];
        $quiz->info_quiz     	  = $request['info_quiz'];
        $quiz->status_quiz     	= $request['status_quiz'];
        $quiz->id_modul     	    = $request['id_modul'];

        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $quiz->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data "'.$request['jenis_quiz'].'" - " '.$request['judul_quiz'].'" Berhasil disimpan.');

        if (Auth::user()->level == 11) {
          return redirect('admin/quiz/');
        }elseif (Auth::user()->level == 12) {
          return redirect('trainer/quiz/');
        }
  }

public function editquiz($id_quiz)
    {
      $data = Quiz::find($id_quiz);
      if (Auth::user()->level == 11) {
       $Modul_learn= Modul::select(DB::raw("id_modul, nama_modul"))
          ->orderBy(DB::raw("id_modul"))
          ->get();
      return view('admin.dashboard.quiz.edit_quiz',$data)
          ->with('Modul_learn', $Modul_learn);
      }elseif (Auth::user()->level == 12) {
        $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();
        $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
        $dataDepartemen = DB::table('departemen_have_moduls')
                   ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                   ->select('departemen_have_moduls.*', 'moduls.nama_modul')
                   ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                   ->orderBy('departemen_have_moduls.nama_departemen', 'asc')->get();
        return view('admin.dashboard.quiz.edit_quiz',$data)
          ->with('dataModul_learn', $Modul_learnTrainer)
          ->with('dataDepartemen', $dataDepartemen);
      }
    }

public function simpanedit(Request $request, $id_quiz)
    {
        $input =$request->all();
        $messages = [
            'jenis_quiz.required'      => 'Jenis Quiz dibutuhkan.',
            'judul_quiz.required'      => 'Judul Quiz dibutuhkan.',
            'departemen_quiz.required'      => 'Departemen Quiz dibutuhkan.',
            'waktu_quiz.required'      => 'Batas Waktu Quiz dibutuhkan.',
            'jumlah_soal.required'            => 'Jumlah Soal dibutuhkan.',
            // 'is_random.required'        => ' dibutuhkan.',
            'pembuat_quiz.required'    => 'Pembuat Quiz dibutuhkan.',
            'tgl_quiz.required'        => 'Tanggal Quiz dibutuhkan.',
            'info_quiz.required'       => 'Info Quiz dibutuhkan.',
            'status_quiz.required'     => 'Status Quiz dibutuhkan.',
            'id_modul.required'         => 'ID Modul dibutuhkan.',
        ];

        $validator = Validator::make($input, [
            'jenis_quiz'       => 'required',
            'judul_quiz'       => 'required',
            'departemen_quiz'       => 'required',
            'waktu_quiz'       => 'required',
            'jumlah_soal'       => 'required',
            // 'is_random'         => 'required',
            'pembuat_quiz'     => 'required',
            'tgl_quiz'         => 'required',
            'info_quiz'        => 'required',
            'status_quiz'      => 'required',
            'id_modul'          => 'required',
        ], $messages);


        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses
        $editQuiz = Quiz::find($id_quiz);
        $editQuiz->jenis_quiz       = $input['jenis_quiz'];
        $editQuiz->judul_quiz     	= $input['judul_quiz'];
        $editQuiz->departemen_quiz     	= $input['departemen_quiz'];
        $editQuiz->waktu_quiz     	= $input['waktu_quiz'];
        $editQuiz->jumlah_soal       = $request->input('jumlah_soal');
        $editQuiz->is_random         = $request->input('is_random');
        $editQuiz->pembuat_quiz     = $input['pembuat_quiz'];
        $editQuiz->tgl_quiz         = $input['tgl_quiz'];
        $editQuiz->info_quiz     	  = $input['info_quiz'];
        $editQuiz->status_quiz     	= $input['status_quiz'];
        $editQuiz->id_modul     	    = $input['id_modul'];

        if (! $editQuiz->save())
          App::abort(500);

        Session::flash('flash_message', 'Data : " '.$input['judul_quiz'].'" Berhasil diubah.');

        if (Auth::user()->level == 11) {
          return redirect('admin/quiz/');
        }elseif (Auth::user()->level == 12) {
          return redirect('trainer/quiz/');
        }
    }

     /**
     * Method store trainee jawab quiz : pilihan ganda
     *
     * @return Response
     */
    public function store_trainee(Request $request)
    {
        $id_quiz = $request->all();
        // dd($id_quiz);
        $trainee = Trainee::where('id_user', Auth::user()->id_user)->first(); // Auth::user()->id_user
        $quiz = Quiz::find($id_quiz['id_quiz']);


        try {
            DB::beginTransaction();
            if (!$id_quiz){
              Session::flash('flash_message', 'Quiz yang kamu pilih tidak ditemukan');
              return Redirect::back();
            }

            if (!$quiz){
              Session::flash('flash_message', 'Quiz tidak ditemukan');
              return Redirect::back();
            }

            $nilaiQuizPilganTrainee = NilaiQuizPilihanGandaTrainee::whereRaw('nik_trainee = ? and id_quiz = ?', array($trainee->nik_trainee, $quiz->id_quiz))->get();

            if (!$nilaiQuizPilganTrainee->isEmpty()){
              Session::flash('flash_message', 'Anda sudah pernah mengambil quiz ini, periksa kembali pada Daftar Pengambilan quiz di Menu Quiz, atau hubungi Admin untuk informasi lebih lanjut');
              return Redirect::back();
            }

            // proses penyimpanan data quiz trainee, dengan nilai sementara pada saat waktu quiz di mulai.
            $nilaiQuizPilganTrainee              = new NilaiQuizPilihanGandaTrainee;
            $nilaiQuizPilganTrainee->id_quiz    = $quiz->id_quiz;
            $nilaiQuizPilganTrainee->nik_trainee  = Trainee::where('id_user', Auth::user()->id_user)->first()->nik_trainee;
            $nilaiQuizPilganTrainee->wkt_mulai   = date('Y-m-d H:i:s');
            $nilaiQuizPilganTrainee->nilai       = 0; //nilai sementara //(4 * 0) - (2 * 0) - $quiz->jumlah_soal + (int)$quiz->waktu_quiz;
            $nilaiQuizPilganTrainee->save();

            // Acak Soal
            // Jika Acak Soal = Ya , maka urutan soal berdasarkan "id_soal" akan di acak dengan 'RAND' -> Random
            // Selain itu, maka soal akan diurutkan berdasarkan waktu pembuatan nya scr ascending
            if ($quiz->is_random) {
                $soalIds = SoalHasQuiz::where('id_quiz', $quiz->id_quiz)->orderBy(DB::raw('RAND()'))->limit($quiz->jumlah_soal)->pluck('id_soal');
            } else {
                $soalIds = SoalHasQuiz::where('id_quiz', $quiz->id_quiz)->orderBy('soal_has_quizs.created_at', 'asc')->limit($quiz->jumlah_soal)->pluck('id_soal');
            }

            foreach ($soalIds as $soalId) {
                $userJawab                           = new TraineeJawabQuizPilihanGanda; // table nya trainee_jawab_quiz_pilgans
                $userJawab->id_soal                  = $soalId;
                $userJawab->id_jawaban_soal_quiz    = null;
                $userJawab->id_nilai_quiz_pilgan    = $nilaiQuizPilganTrainee->id_nilai_quiz_pilgan;
                $userJawab->save();
            }
            // dd($userJawab);
            DB::commit();

            return Redirect::action('Admin\SoalQuizController@show', array($nilaiQuizPilganTrainee->id_nilai_quiz_pilgan, $soalIds[0]))->with('messages',
                array(
                    array('success', 'Selamat Mengerjakan')
                ));

        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return Redirect::action('Admin\QuizController@show', array($id_quiz))->with('messages',
                array(
                    array('error', $e->getMessage())
                ));

        }

    }

public function show($id_quiz)
  {
    try {

        $nilaiQuizPilganTrainee = NilaiQuizPilihanGandaTrainee::where('id_nilai_quiz_pilgan',$id_quiz)->first();
        // $nilaiQuizPilganTrainee = NilaiQuizPilihanGandaTrainee::find($id_quiz);
        // dd($nilaiQuizPilganTrainee);

        $id_user = Trainee::where('nik_trainee', $nilaiQuizPilganTrainee->nik_trainee)->first()->id_user; // persamaan dari : $nilaiQuizPilganTrainee->nik_trainee->id_user

        if (!$nilaiQuizPilganTrainee){
                Session::flash('flash_message', 'Informasi pengambilan kuis tidak ditemukan');
                return Redirect::back();
            }

        if ($id_user != Auth::user()->id_user){
                Session::flash('flash_message', 'Admin dan Trainer Berhak Melihat Detail dari Quiznya Trainee');
            }

        // $quiz = Quiz::find($nilaiQuizPilganTrainee->id_quiz);
        // pake join lebih mantap
        $quiz = DB::table('quizs')
                 ->join('moduls', 'quizs.id_modul', '=', 'moduls.id_modul')
                 ->select('quizs.*', 'moduls.nama_modul')
                 ->where('quizs.id_quiz', $nilaiQuizPilganTrainee->id_quiz)
                 ->first();
        // dd($quiz);

        if (!$quiz){
                Session::flash('flash_message', 'Detail Quiz dengan id ' . $nilaiQuizPilganTrainee->id_quiz . ' tidak ditemukan');
                return Redirect::back();
            }

        //tampilkan jawaban dan soals
          // userJawab nanti ganti jadi traineeJawab
          // $userJawab = TraineeJawabQuizPilihanGanda::whereRaw('id_nilai_quiz_pilgan = ?', array($nilaiQuizPilganTrainee->id_nilai_quiz_pilgan))->get();
        // pake join mantap
        $userJawab = DB::table('trainee_jawab_quiz_pilgans')
                 ->join('soals', 'trainee_jawab_quiz_pilgans.id_soal', '=', 'soals.id_soal')
                 ->select('trainee_jawab_quiz_pilgans.*', 'soals.pertanyaan', 'soals.id_quiz')
                 ->where('trainee_jawab_quiz_pilgans.id_nilai_quiz_pilgan', $nilaiQuizPilganTrainee->id_nilai_quiz_pilgan)
                 ->get();
        // dd($userJawab);
        $interval = '';
        if ($nilaiQuizPilganTrainee->wkt_selesai) {
            $start_date  = new \DateTime($nilaiQuizPilganTrainee->wkt_mulai);
            $since_start = $start_date->diff(new \DateTime($nilaiQuizPilganTrainee->wkt_selesai));
            $interval    = $since_start->h . ' jam ' . $since_start->i . ' menit ' . $since_start->s . ' detik';
        }

        //formatting
        foreach ($userJawab as $jawab) {
            $jawab->is_kosong = false;
            $jawab->is_benar  = false;
            $soals = Soal::where('id_quiz', $jawab->id_quiz)->get();
            $soals2 = DB::table('soals')
                 ->join('jawaban_soal_quizs', 'soals.id_soal', '=', 'jawaban_soal_quizs.id_soal')
                 ->select('soals.*', 'jawaban_soal_quizs.*')
                 ->where('soals.id_quiz', $nilaiQuizPilganTrainee->id_quiz)
                 ->first();

            if (!$jawab->id_jawaban_soal_quiz)
                $jawab->is_kosong = true;
            else {
                //get jawaban benar of soal
                $jawabanBenars = JawabanSoalQuiz::where('id_soal', $jawab->id_soal)->get()->filter(function ($jawaban) {
                    if ($jawaban->is_benar) {
                        return $jawaban;
                    }
                });

                $isBenar = false;
                foreach ($jawabanBenars as $jawabanBenarFromSoal) {
                    if ($jawab->id_jawaban_soal_quiz == $jawabanBenarFromSoal->id_jawaban_soal_quiz) {
                        $isBenar = true;
                    }
                }

                if ($isBenar)
                    $jawab->is_benar = true;
            }
        }

        return view('admin.dashboard.quiz.show_hasil_quiz')
            ->with('quiz', $quiz)
            ->with('userjawabquiz', $nilaiQuizPilganTrainee)
            ->with('userJawab', $userJawab)
            ->with('soals', $soals)
            // ->with('jawabans', $jawabans)
            ->with('interval', $interval);

    } catch (Exception $e) {
        return Redirect::action('Admin\QuizController@index_trainee')->with('messages',
            array(
                array('error', $e->getMessage())
            ));
       //  DashboardController@index atau trainee/quiz
    }
  }

public function destroy($id)
  {
      try {
          DB::beginTransaction();
          $nilaiQuizPilganTrainee = NilaiQuizPilihanGandaTrainee::find($id);

          if (!$nilaiQuizPilganTrainee)
              throw new Exception('Informasi pengambilan Quiz tidak ditemukan');

          //hapus user jawab
          $userJawab = TraineeJawabQuizPilihanGanda::whereRaw('id_trainee_jawab_quiz_pilgan = ? ', array($nilaiQuizPilganTrainee->id_trainee_jawab_quiz_pilgan))->get();
          foreach ($userJawab as $uj) {
              $uj->delete();
          }
          $nilaiQuizPilganTrainee->delete();

          DB::commit();
          Session::flash('flash_message', 'Pengambilan Quiz berhasil dihapus');
          if (Auth::user()->level == 11) {
            return redirect('admin/quiz/'.$nilaiQuizPilganTrainee->id_quiz.'/detail ');
          }else if (Auth::user()->level == 12) {
            return redirect('trainer/quiz/'.$nilaiQuizPilganTrainee->id_quiz.'/detail ');
          }

      } catch (Exception $e) {
          DB::rollback();
          if ($nilaiQuizPilganTrainee)
              if (Auth::user()->level == 11) {
                  return redirect('admin/quiz/'.$nilaiQuizPilganTrainee->id_quiz.'/detail ');
                }else if (Auth::user()->level == 12) {
                  return redirect('trainer/quiz/'.$nilaiQuizPilganTrainee->id_quiz.'/detail ');
                }
          else
              return Redirect::action('Admin\QuizController@index_trainee')->with('messages',
                  array(
                      array('error', $e->getMessage())
                  ));


      }
  }


} // end of code
