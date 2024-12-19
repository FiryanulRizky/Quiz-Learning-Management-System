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
use App\Modul as Modul;
use App\TraineeJawabUjianPilihanGanda as TraineeJawabUjianPilihanGanda;
use App\NilaiUjianPilihanGandaTrainee as NilaiUjianPilihanGandaTrainee;
use App\JawabanSoalUjian as JawabanSoalUjian;
use App\SoalHasUjian as SoalHasUjian;
use Session;

class UjianController extends Controller
{
public function __construct()
  {
    $this->middleware('auth');
  }

public function showTambahUjian()
  {
    if (Auth::user()->level == 11) {
     $Modul_learn= Modul::select(DB::raw("id_modul, nama_modul"))
        ->orderBy(DB::raw("id_modul"))
        ->get();

    return view('admin.dashboard.ujian.tambah_ujian')
        ->with('Modul_learn', $Modul_learn);

    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
      $dataDepartemen = DB::table('departemen_have_moduls')
                 ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                 ->select('departemen_have_moduls.*', 'moduls.nama_modul')
                 ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                 ->orderBy('departemen_have_moduls.nama_departemen', 'asc')->get();
      return view('admin.dashboard.ujian.tambah_ujian')
        ->with('dataModul_learn', $Modul_learnTrainer)
        ->with('dataDepartemen', $dataDepartemen);
    }
  }

public function detail($id_ujian)
  {
    $data = Ujian::find($id_ujian);
    $ujian = Ujian::orderBy('id_ujian')->get();
    $dataUjian = DB::table('ujians')
                 ->join('moduls', 'ujians.id_modul', '=', 'moduls.id_modul')
                 ->select('ujians.*', 'moduls.nama_modul')
                 ->where('ujians.id_ujian', $id_ujian)
                 ->first();

    // dd($dataUjian);
    // revisi check waktu ujian
    $wkt_ujian  = $dataUjian->tgl_ujian;
    $wkt_sekarang = Date('Y-m-d');
    if ($wkt_sekarang > $wkt_ujian) {
          Session::flash('flash_message', 'Batas akhir ujian Sudah Berakhir !!! Hubungi trainer anda.');
          return Redirect::back();
    }

    $dataSoalUjianDetail = DB::table('soals')
         ->join('ujians', 'soals.id_ujian', '=', 'ujians.id_ujian')
         ->leftjoin('moduls','ujians.id_modul','=','moduls.id_modul')
         ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
         ->select('soals.*', 'ujians.*', 'moduls.nama_modul', 'trainers.nama_trainer')
         ->where('soals.id_ujian', $id_ujian)
         ->get();

    $dataJawabanSoal = DB::table('jawaban_soal_ujians')
         ->join('soals','jawaban_soal_ujians.id_soal','=','soals.id_soal')
         ->leftjoin('ujians', 'soals.id_ujian', '=', 'ujians.id_ujian')
         ->select('jawaban_soal_ujians.poin', 'jawaban_soal_ujians.id_soal')
         ->get();

    $maxPoint = 0;
    foreach ($dataJawabanSoal as $jawaban){
        if ($jawaban->poin > $maxPoint)
            (int)$maxPoint = $jawaban->poin;
        }

    $countSoalPilgan   = Soal::where('jenis_soal', '=', 'Pilihan Ganda')->where('id_ujian', '=', $id_ujian)->count();
    $countSoalEssay   = Soal::where('jenis_soal', '=', 'Essay')->where('id_ujian', '=', $id_ujian)->count();
    $countSoalDetail   = Soal::where('id_ujian', '=', $id_ujian)->count();

    // dd($countSoalDetail);
    return view('admin.dashboard.ujian.detail_ujian', $data)
            ->with('countSoalPilgan', $countSoalPilgan)
            ->with('countSoalEssay', $countSoalEssay)
            ->with('countSoalDetail', $countSoalDetail)
            ->with('soal_ujian', $dataSoalUjianDetail)
            ->with('poin', $maxPoint)
            ->with('ujian', $dataUjian);
  }

public function index()
  {
    if (Auth::user()->level == 11) {
      $dataUjian = DB::table('ujians')
                 ->join('moduls', 'ujians.id_modul', '=', 'moduls.id_modul')
                 ->select('ujians.*', 'moduls.nama_modul')
                 ->get();
    }elseif (Auth::user()->level == 12) {
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
      $dataUjian = DB::table('ujians')
                 ->join('moduls', 'ujians.id_modul', '=', 'moduls.id_modul')
                 ->select('ujians.*', 'moduls.nama_modul')
                 ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                 ->get();
    }
    $data = array('ujian' => $dataUjian);
    return view('admin.dashboard.ujian.ujian',$data);
  }

  // daftar ujian trainee dan daftar pengambilan ujian trainee
public function index_trainee()
  {
    $id_user = Auth::user()->id_user;
    $trainee = Trainee::where('id_user',$id_user)->first();
    $nisn = $trainee->nik_trainee;

    $dataUjian = DB::table('ujians')
                 ->join('moduls', 'ujians.id_modul', '=', 'moduls.id_modul')
                 ->select('ujians.*', 'moduls.nama_modul')
                 ->where('departemen_ujian', $trainee->departemen_trainee)
                 ->where('status_ujian', 'Aktif')
                 ->get();

    $data = array('ujianTrainee' => $dataUjian);

    $countUjianTrainee   = Ujian::where('departemen_ujian', $trainee->departemen_trainee)->get()->count(); // berdasarkan departemen nya trainee masing masing

    $userJawabLembar = NilaiUjianPilihanGandaTrainee::whereRaw('nik_trainee = ?', array($nisn))->orderBy('id_nilai_ujian_pilgan', 'desc')->get();
    $userJawabLembars = DB::table('nilai_ujian_pilgan_trainees')
                 ->join('ujians', 'nilai_ujian_pilgan_trainees.id_ujian', '=', 'ujians.id_ujian')
                 ->select('ujians.judul_ujian', 'ujians.jenis_ujian', 'ujians.tgl_ujian', 'nilai_ujian_pilgan_trainees.*')
                 ->whereRaw('nik_trainee = ?', array($nisn))->orderBy('id_nilai_ujian_pilgan', 'desc')->get();
    // new
    // $soals = Soal::orderBy('updated_at', 'desc')->get();

    return view('admin.dashboard.ujian.ujian',$data)
            ->with('trainee', $trainee)
            ->with('userJawabLembars', $userJawabLembar)
            ->with('countUjian', $countUjianTrainee);
  }

public function hapus($id_ujian)
  {

    $id_ujian = Ujian::where('id_ujian', '=', $id_ujian)->first();
//dd($id_ujian);
    if ($id_ujian == null)
      \app::abort(404);

    Session::flash('flash_message', 'Data Ujian "'.$id_ujian->judul_ujian.'" - "'.$id_ujian->info_ujian.'" Berhasil dihapus.');

    $id_ujian->delete();

    if (Auth::user()->level == 11) {
      return redirect('admin/ujian/');
    }elseif (Auth::user()->level == 12) {
      return redirect('trainer/ujian/');
    }
  }

public function tambah(Request $request)
  {
        $input =$request->all();
        // revisi check waktu ujian
        $wkt_ujian  = $request['tgl_ujian'];
        $wkt_sekarang = Date('Y-m-d');
        if ($wkt_sekarang > $wkt_ujian) {
              Session::flash('flash_message', 'Tanggal ujian harus lebih dari waktu sekarang !!!');
              return Redirect::back();
        }

        $pesan = array(
        	'jenis_ujian.required' 		  => 'Jenis Ujian dibutuhkan.',
            'judul_ujian.required'      => 'Judul Ujian dibutuhkan.',
            'departemen_ujian.required'      => 'Departemen Ujian dibutuhkan.',
            'waktu_ujian.required'      => 'Batas Waktu Ujian dibutuhkan.',
            'jumlah_soal.required'            => 'Jumlah Soal dibutuhkan.',
            // 'is_random.required'        => ' dibutuhkan.',
            'pembuat_ujian.required'    => 'Pembuat Ujian dibutuhkan.',
            'tgl_ujian.required'        => 'Tanggal Ujian dibutuhkan.',
            'info_ujian.required'       => 'Info Ujian dibutuhkan.',
            'status_ujian.required'     => 'Status Ujian dibutuhkan.',
            'id_modul.required'         => 'ID Modul dibutuhkan.',

        );

        $aturan = array(
            'jenis_ujian'       => 'required',
            'judul_ujian'       => 'required',
            'departemen_ujian'       => 'required',
            'waktu_ujian'       => 'required|numeric|min:1',
            'jumlah_soal'       => 'required|numeric|min:1',
            // 'is_random'         => 'required',
            'pembuat_ujian'     => 'required',
            'tgl_ujian'         => 'required',
            'info_ujian'        => 'required',
            'status_ujian'      => 'required',
            'id_modul'          => 'required',

        );


        $validator = Validator::make($input,$aturan, $pesan);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses

        $ujian = new Ujian;
        $ujian->jenis_ujian       = $request['jenis_ujian'];
        $ujian->judul_ujian     	= $request['judul_ujian'];
        $ujian->departemen_ujian     	= $request['departemen_ujian'];
        $ujian->waktu_ujian     	= $request['waktu_ujian'];
        $ujian->jumlah_soal       = $request['jumlah_soal'];
        $ujian->is_random         = $request['is_random'];
        $ujian->pembuat_ujian     = $request['pembuat_ujian'];
        $ujian->tgl_ujian         = $request['tgl_ujian'];
        $ujian->info_ujian     	  = $request['info_ujian'];
        $ujian->status_ujian     	= $request['status_ujian'];
        $ujian->id_modul     	    = $request['id_modul'];

        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $ujian->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data "'.$request['jenis_ujian'].'" - " '.$request['judul_ujian'].'" Berhasil disimpan.');

        if (Auth::user()->level == 11) {
          return redirect('admin/ujian/');
        }elseif (Auth::user()->level == 12) {
          return redirect('trainer/ujian/');
        }
  }

public function editujian($id_ujian)
    {
      $data = Ujian::find($id_ujian);
      if (Auth::user()->level == 11) {
       $Modul_learn= Modul::select(DB::raw("id_modul, nama_modul"))
          ->orderBy(DB::raw("id_modul"))
          ->get();
      return view('admin.dashboard.ujian.edit_ujian',$data)
          ->with('Modul_learn', $Modul_learn);
      }elseif (Auth::user()->level == 12) {
        $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();
        $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
        $dataDepartemen = DB::table('departemen_have_moduls')
                   ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                   ->select('departemen_have_moduls.*', 'moduls.nama_modul')
                   ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                   ->orderBy('departemen_have_moduls.nama_departemen', 'asc')->get();
        return view('admin.dashboard.ujian.edit_ujian',$data)
          ->with('dataModul_learn', $Modul_learnTrainer)
          ->with('dataDepartemen', $dataDepartemen);
      }
    }

public function simpanedit(Request $request, $id_ujian)
    {
        $input =$request->all();
        $messages = [
            'jenis_ujian.required'      => 'Jenis Ujian dibutuhkan.',
            'judul_ujian.required'      => 'Judul Ujian dibutuhkan.',
            'departemen_ujian.required'      => 'Departemen Ujian dibutuhkan.',
            'waktu_ujian.required'      => 'Batas Waktu Ujian dibutuhkan.',
            'jumlah_soal.required'            => 'Jumlah Soal dibutuhkan.',
            // 'is_random.required'        => ' dibutuhkan.',
            'pembuat_ujian.required'    => 'Pembuat Ujian dibutuhkan.',
            'tgl_ujian.required'        => 'Tanggal Ujian dibutuhkan.',
            'info_ujian.required'       => 'Info Ujian dibutuhkan.',
            'status_ujian.required'     => 'Status Ujian dibutuhkan.',
            'id_modul.required'         => 'ID Modul dibutuhkan.',
        ];

        $validator = Validator::make($input, [
            'jenis_ujian'       => 'required',
            'judul_ujian'       => 'required',
            'departemen_ujian'       => 'required',
            'waktu_ujian'       => 'required',
            'jumlah_soal'       => 'required',
            // 'is_random'         => 'required',
            'pembuat_ujian'     => 'required',
            'tgl_ujian'         => 'required',
            'info_ujian'        => 'required',
            'status_ujian'      => 'required',
            'id_modul'          => 'required',
        ], $messages);


        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses
        $editUjian = Ujian::find($id_ujian);
        $editUjian->jenis_ujian       = $input['jenis_ujian'];
        $editUjian->judul_ujian     	= $input['judul_ujian'];
        $editUjian->departemen_ujian     	= $input['departemen_ujian'];
        $editUjian->waktu_ujian     	= $input['waktu_ujian'];
        $editUjian->jumlah_soal       = $request->input('jumlah_soal');
        $editUjian->is_random         = $request->input('is_random');
        $editUjian->pembuat_ujian     = $input['pembuat_ujian'];
        $editUjian->tgl_ujian         = $input['tgl_ujian'];
        $editUjian->info_ujian     	  = $input['info_ujian'];
        $editUjian->status_ujian     	= $input['status_ujian'];
        $editUjian->id_modul     	    = $input['id_modul'];

        if (! $editUjian->save())
          App::abort(500);

        Session::flash('flash_message', 'Data : " '.$input['judul_ujian'].'" Berhasil diubah.');

        if (Auth::user()->level == 11) {
          return redirect('admin/ujian/');
        }elseif (Auth::user()->level == 12) {
          return redirect('trainer/ujian/');
        }
    }

     /**
     * Method store trainee jawab ujian : pilihan ganda
     *
     * @return Response
     */
    public function store_trainee(Request $request)
    {
        $id_ujian = $request->all();
        // dd($id_ujian);
        $trainee = Trainee::where('id_user', Auth::user()->id_user)->first(); // Auth::user()->id_user
        $ujian = Ujian::find($id_ujian['id_ujian']);


        try {
            DB::beginTransaction();
            if (!$id_ujian){
              Session::flash('flash_message', 'Ujian yang kamu pilih tidak ditemukan');
              return Redirect::back();
            }

            if (!$ujian){
              Session::flash('flash_message', 'Ujian tidak ditemukan');
              return Redirect::back();
            }

            $nilaiUjianPilganTrainee = NilaiUjianPilihanGandaTrainee::whereRaw('nik_trainee = ? and id_ujian = ?', array($trainee->nik_trainee, $ujian->id_ujian))->get();

            if (!$nilaiUjianPilganTrainee->isEmpty()){
              Session::flash('flash_message', 'Anda sudah pernah mengambil ujian ini, periksa kembali pada Daftar Pengambilan ujian di Menu Ujian, atau hubungi Admin untuk informasi lebih lanjut');
              return Redirect::back();
            }

            // proses penyimpanan data ujian trainee, dengan nilai sementara pada saat waktu ujian di mulai.
            $nilaiUjianPilganTrainee              = new NilaiUjianPilihanGandaTrainee;
            $nilaiUjianPilganTrainee->id_ujian    = $ujian->id_ujian;
            $nilaiUjianPilganTrainee->nik_trainee  = Trainee::where('id_user', Auth::user()->id_user)->first()->nik_trainee;
            $nilaiUjianPilganTrainee->wkt_mulai   = date('Y-m-d H:i:s');
            $nilaiUjianPilganTrainee->nilai       = 0; //nilai sementara //(4 * 0) - (2 * 0) - $ujian->jumlah_soal + (int)$ujian->waktu_ujian;
            $nilaiUjianPilganTrainee->save();

            // Acak Soal
            // Jika Acak Soal = Ya , maka urutan soal berdasarkan "id_soal" akan di acak dengan 'RAND' -> Random
            // Selain itu, maka soal akan diurutkan berdasarkan waktu pembuatan nya scr ascending
            if ($ujian->is_random) {
                $soalIds = SoalHasUjian::where('id_ujian', $ujian->id_ujian)->orderBy(DB::raw('RAND()'))->limit($ujian->jumlah_soal)->pluck('id_soal');
            } else {
                $soalIds = SoalHasUjian::where('id_ujian', $ujian->id_ujian)->orderBy('soal_has_ujians.created_at', 'asc')->limit($ujian->jumlah_soal)->pluck('id_soal');
            }

            foreach ($soalIds as $soalId) {
                $userJawab                           = new TraineeJawabUjianPilihanGanda; // table nya trainee_jawab_ujian_pilgans
                $userJawab->id_soal                  = $soalId;
                $userJawab->id_jawaban_soal_ujian    = null;
                $userJawab->id_nilai_ujian_pilgan    = $nilaiUjianPilganTrainee->id_nilai_ujian_pilgan;
                $userJawab->save();
            }
            // dd($userJawab);
            DB::commit();

            return Redirect::action('Admin\SoalUjianController@show', array($nilaiUjianPilganTrainee->id_nilai_ujian_pilgan, $soalIds[0]))->with('messages',
                array(
                    array('success', 'Selamat Mengerjakan')
                ));

        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return Redirect::action('Admin\UjianController@show', array($id_ujian))->with('messages',
                array(
                    array('error', $e->getMessage())
                ));

        }

    }

public function show($id_ujian)
  {
    try {

        $nilaiUjianPilganTrainee = NilaiUjianPilihanGandaTrainee::where('id_nilai_ujian_pilgan',$id_ujian)->first();
        // $nilaiUjianPilganTrainee = NilaiUjianPilihanGandaTrainee::find($id_ujian);
        // dd($nilaiUjianPilganTrainee);

        $id_user = Trainee::where('nik_trainee', $nilaiUjianPilganTrainee->nik_trainee)->first()->id_user; // persamaan dari : $nilaiUjianPilganTrainee->nik_trainee->id_user

        if (!$nilaiUjianPilganTrainee){
                Session::flash('flash_message', 'Informasi pengambilan kuis tidak ditemukan');
                return Redirect::back();
            }

        if ($id_user != Auth::user()->id_user){
                Session::flash('flash_message', 'Admin dan Trainer Berhak Melihat Detail dari Ujiannya Trainee');
            }

        // $ujian = Ujian::find($nilaiUjianPilganTrainee->id_ujian);
        // pake join lebih mantap
        $ujian = DB::table('ujians')
                 ->join('moduls', 'ujians.id_modul', '=', 'moduls.id_modul')
                 ->select('ujians.*', 'moduls.nama_modul')
                 ->where('ujians.id_ujian', $nilaiUjianPilganTrainee->id_ujian)
                 ->first();
        // dd($ujian);

        if (!$ujian){
                Session::flash('flash_message', 'Detail Ujian dengan id ' . $nilaiUjianPilganTrainee->id_ujian . ' tidak ditemukan');
                return Redirect::back();
            }

        //tampilkan jawaban dan soals
          // userJawab nanti ganti jadi traineeJawab
          // $userJawab = TraineeJawabUjianPilihanGanda::whereRaw('id_nilai_ujian_pilgan = ?', array($nilaiUjianPilganTrainee->id_nilai_ujian_pilgan))->get();
        // pake join mantap
        $userJawab = DB::table('trainee_jawab_ujian_pilgans')
                 ->join('soals', 'trainee_jawab_ujian_pilgans.id_soal', '=', 'soals.id_soal')
                 ->select('trainee_jawab_ujian_pilgans.*', 'soals.pertanyaan', 'soals.id_ujian')
                 ->where('trainee_jawab_ujian_pilgans.id_nilai_ujian_pilgan', $nilaiUjianPilganTrainee->id_nilai_ujian_pilgan)
                 ->get();
        // dd($userJawab);
        $interval = '';
        if ($nilaiUjianPilganTrainee->wkt_selesai) {
            $start_date  = new \DateTime($nilaiUjianPilganTrainee->wkt_mulai);
            $since_start = $start_date->diff(new \DateTime($nilaiUjianPilganTrainee->wkt_selesai));
            $interval    = $since_start->h . ' jam ' . $since_start->i . ' menit ' . $since_start->s . ' detik';
        }

        //formatting
        foreach ($userJawab as $jawab) {
            $jawab->is_kosong = false;
            $jawab->is_benar  = false;
            $soals = Soal::where('id_ujian', $jawab->id_ujian)->get();
            $soals2 = DB::table('soals')
                 ->join('jawaban_soal_ujians', 'soals.id_soal', '=', 'jawaban_soal_ujians.id_soal')
                 ->select('soals.*', 'jawaban_soal_ujians.*')
                 ->where('soals.id_ujian', $nilaiUjianPilganTrainee->id_ujian)
                 ->first();

            if (!$jawab->id_jawaban_soal_ujian)
                $jawab->is_kosong = true;
            else {
                //get jawaban benar of soal
                $jawabanBenars = JawabanSoalUjian::where('id_soal', $jawab->id_soal)->get()->filter(function ($jawaban) {
                    if ($jawaban->is_benar) {
                        return $jawaban;
                    }
                });

                $isBenar = false;
                foreach ($jawabanBenars as $jawabanBenarFromSoal) {
                    if ($jawab->id_jawaban_soal_ujian == $jawabanBenarFromSoal->id_jawaban_soal_ujian) {
                        $isBenar = true;
                    }
                }

                if ($isBenar)
                    $jawab->is_benar = true;
            }
        }

        return view('admin.dashboard.ujian.show_hasil_ujian')
            ->with('ujian', $ujian)
            ->with('userjawabujian', $nilaiUjianPilganTrainee)
            ->with('userJawab', $userJawab)
            ->with('soals', $soals)
            // ->with('jawabans', $jawabans)
            ->with('interval', $interval);

    } catch (Exception $e) {
        return Redirect::action('Admin\UjianController@index_trainee')->with('messages',
            array(
                array('error', $e->getMessage())
            ));
       //  DashboardController@index atau trainee/ujian
    }
  }

public function destroy($id)
  {
      try {
          DB::beginTransaction();
          $nilaiUjianPilganTrainee = NilaiUjianPilihanGandaTrainee::find($id);

          if (!$nilaiUjianPilganTrainee)
              throw new Exception('Informasi pengambilan Ujian tidak ditemukan');

          //hapus user jawab
          $userJawab = TraineeJawabUjianPilihanGanda::whereRaw('id_trainee_jawab_ujian_pilgan = ? ', array($nilaiUjianPilganTrainee->id_trainee_jawab_ujian_pilgan))->get();
          foreach ($userJawab as $uj) {
              $uj->delete();
          }
          $nilaiUjianPilganTrainee->delete();

          DB::commit();
          Session::flash('flash_message', 'Pengambilan Ujian berhasil dihapus');
          if (Auth::user()->level == 11) {
            return redirect('admin/ujian/'.$nilaiUjianPilganTrainee->id_ujian.'/detail ');
          }else if (Auth::user()->level == 12) {
            return redirect('trainer/ujian/'.$nilaiUjianPilganTrainee->id_ujian.'/detail ');
          }

      } catch (Exception $e) {
          DB::rollback();
          if ($nilaiUjianPilganTrainee)
              if (Auth::user()->level == 11) {
                  return redirect('admin/ujian/'.$nilaiUjianPilganTrainee->id_ujian.'/detail ');
                }else if (Auth::user()->level == 12) {
                  return redirect('trainer/ujian/'.$nilaiUjianPilganTrainee->id_ujian.'/detail ');
                }
          else
              return Redirect::action('Admin\UjianController@index_trainee')->with('messages',
                  array(
                      array('error', $e->getMessage())
                  ));


      }
  }


} // end of code
