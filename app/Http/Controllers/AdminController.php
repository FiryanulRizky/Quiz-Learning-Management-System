<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use Response;
use DB;
use Session;
use Hash;
use App\Click as Click;
use App\View as View;
use App\User as User;
use App\Trainee as Trainee;
use App\Trainer as Trainer;
use App\DepartemenHaveModul as Departemen;
use App\Modul as Modul;
use App\Pengumuman as Pengumuman;
use App\MateriModul as MateriModul;
use App\Tugas as Tugas;
use App\Quiz as Quiz;
use App\Soal as Soal;

class AdminController extends Controller
{

    public function __construct(Request $request)
    {
      $this->middleware('auth');      
    }    

    public function showTambahUser()
    {
      $idUser= User::select(DB::raw("id_user, username"))
          ->orderBy(DB::raw("id_user"))        
          ->get();
      return view('admin.dashboard.user.tambah_user');
          // ->with('listIduser', $idUser);
    }

    public function index_user()
    {
      $dataUser = User::all();        
      $data = array('user' => $dataUser);   
      return view('admin.dashboard.user.user',$data);
    }
        /**
     * Method Membuat akun baru
     *
     * @return Response
     */
    public function createAkunNew(Request $request)
    {
      // $level = $request['level'];      
      $input =$request->all();
      $pesan = array(
            'name.required'       => 'Nama Pengguna dibutuhkan.',
            'username.required'       => 'Username dibutuhkan.',
            'email.required'       => 'Email dibutuhkan.',
            'password.required'       => 'Password dibutuhkan.',
            'level.required'       => 'Jenis Hak Akses dibutuhkan.',
        );

        $aturan = array(
            'name'        => 'required',
            'username'        => 'required',
            'email'        => 'required',
            'password'        => 'required',
            'level'        => 'required',
        );
        
        $validator = Validator::make($input,$aturan, $pesan);

        if($validator->fails()) {
          # Kembali kehalaman yang sama dengan pesan error
          return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses
        // buat akun baru
        $akunNew = new User;
        $akunNew->name        = $request['name'];
        $akunNew->username    = $request['username'];
        $akunNew->email       = $request['email'];
        $akunNew->password    = $request['password'];
        $akunNew->level       = $request['level'];

        if (! $akunNew->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data User Baru "'.$request['username'].'" - " '.$request['email'].'" Berhasil disimpan.');

        return Redirect::action('AdminController@index_user');
     
    }

    public function hapus($id_user)
    {
    
      $id_user = User::where('id_user', '=', $id_user)->first();

      if ($id_user == null)
        app::abort(404);
      
      Session::flash('flash_message', 'Data User "'.$id_user->id_user.'" - "'.$id_user->name.'" Berhasil dihapus.');

      $id_user->delete();
      
      return Redirect::action('AdminController@index_user');

    }

     public function edituser($id_user)
    {

        $data = User::find($id_user);
        // dd($data->password);

        return view('admin.dashboard.user.edit_user',$data);                
    }

 public function simpanedit(Request $request, $id_user)
    {
        $input =$request->all();
        // dd($input);
        $pesan = array(
            'name.required'       => 'Nama Pengguna dibutuhkan.',
            'username.required'       => 'Username dibutuhkan.',
            'email.required'       => 'Email dibutuhkan.',
            'password.required'       => 'Password dibutuhkan.',
            'level.required'       => 'Jenis Hak Akses dibutuhkan.',
        );

        $aturan = array(
            'name'        => 'required',
            'username'        => 'required',
            'email'        => 'sometimes',
            'password'        => 'sometimes',
            'level'        => 'required',
        );

        $validator = Validator::make($input,$aturan, $pesan);
        // tipe validasi 1 
        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();          
        }
        # Bila validasi sukses
        $akunEdit = User::find($id_user);
        $akunEdit->name        = $input['name'];
        $akunEdit->username    = $input['username'];
        $akunEdit->email       = $input['email'];
        // $akunEdit->password    = $input['password'];
        $akunEdit->level       = $input['level'];               

        if (! $akunEdit->save())
          App::abort(500);

        Session::flash('flash_message', 'Data User "'.$input['username'].'" - " '.$input['email'].'" Berhasil diubah.');

        return Redirect::action('AdminController@index_user');                
    }

    
    public function test_view()
    {
      return view('test_view');
    }

    public function showUbahPasswordUserAdmin($id_user)
    {      
      $user = User::find($id_user);
      return view('users.ubah_password_user')
              ->with('user', $user);
    }

    public function showUbahPasswordUser()
    {    
      $user = Auth::user();
      return view('users.ubah_password_user')
              ->with('user', $user);
    }

    public function simpanubahpassworduser()
    {                
        if (Auth::user()->level == 11) {
          $request = $request->all();      
          $user = User::find($request['id_user']);   

          $messages = array(            
            'newpassword.required' => 'Anda belum mengisi password baru',            
            'newpassword.min' => 'Password baru kurang dari 6 karakter',            
        );

        $rules = [                        
            'newpassword' => 'required|min:6',            
          ];
        }
        else{
          $request = $request->all();
          $user = Auth::user(); 

          Validator::extend('passcheck', function($attribute, $value, $parameters) {            
            return Hash::check($value, Auth::user()->password);
          });          

          $messages = array(
            'passcheck' => 'Password lama tidak sesuai dengan database',
            'oldpassword.required' => 'Anda belum mengisi password lama',
            'newpassword.required' => 'Anda belum mengisi password baru',
            'newpassword_confirmation.required' => 'Anda belum mengisi konfirmasi password baru',
            'newpassword.min' => 'Password baru kurang dari 6 karakter',
            'newpassword.confirmed' => 'Password baru tidak sesuai konfirmasi',
        );

        $rules = [
            'oldpassword' => 'passcheck',
            'oldpassword' => 'required',            
            'newpassword' => 'required|min:6|confirmed',
            'newpassword_confirmation' => 'required',
          ];
        }
        

        $validator = Validator::make($request,$rules,$messages);
        // tipe validasi 2
        if($validator->passes()){                        
            $user->password = bcrypt($request['newpassword']);            
            $user->save();

            if (Auth::user()->level == 11) {
              Session::flash('flash_message', 'Password user berhasil diubah');
            } else {
              Session::flash('flash_message', 'Anda telah berhasil melakukan perubahan password, silahkan login kembali untuk mengaktifkanya');              
            }
                         
            return Redirect::action('AdminController@index_user');
        }else{
          return Redirect::back()->withErrors($validator)->withInput(); 
        }
    }

    public function index(Request $request){
      $level = Auth::user()->level;

      switch ($level) {
        case "11":
            return $this->dashboardLevel11(); //Admin
            break;
        case "12":
            return $this->dashboardLevel12(); //Trainer
            break;
        case "13":
            return $this->dashboardLevel13(); //Trainee
            break;        
        default:
            return "Dashboard SI E-Learning!";
      }
    }    

  public function dashBoardLevel11(){    
      $countTrainee   = Trainee::count();
      $countTrainer   = Trainer::count();
      $countModul_learn   = Modul::count();
      $countPengumuman   = Pengumuman::count();
      $countMateriModul   = MateriModul::count();
      $countTugas   = Tugas::count();
      $countSoal   = Soal::count();
      $countQuiz   = Quiz::count();
      return view('admin.dashboard.index.main_admin')
             ->with('countTrainee', $countTrainee)
             ->with('countTrainer', $countTrainer)
             ->with('countModul_learn', $countModul_learn)
             ->with('countPengumuman', $countPengumuman)
             ->with('countMateriModul', $countMateriModul)
             ->with('countTugas', $countTugas)
             ->with('countSoal', $countSoal)
             ->with('countQuiz', $countQuiz);
    }

  public function dashBoardLevel12(){            
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
      $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();         
      $dataMateriModul = DB::table('materi_moduls')                                                          
       ->join('moduls', 'materi_moduls.id_modul', '=', 'moduls.id_modul')       
       ->select('materi_moduls.*', 'moduls.nama_modul')
       ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
       ->get(); 
      $countMateriModul   = count($dataMateriModul);
      $dataTugas = DB::table('tugass')                  
                 ->join('moduls', 'tugass.id_modul', '=', 'moduls.id_modul')
                 ->select('tugass.*', 'moduls.nama_modul')
                 ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                 ->get();
      $countTugas   = count($dataTugas);
      $dataSoalQuiz = DB::table('soals')   
               ->join('quizs', 'soals.id_quiz', '=', 'quizs.id_quiz') 
               ->leftjoin('moduls','quizs.id_modul','=','moduls.id_modul')
               ->leftjoin('trainers','moduls.nik_trainer','=','trainers.nik_trainer')
               ->select('soals.*', 'quizs.*', 'moduls.nama_modul', 'trainers.nama_trainer')
               ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
               ->get(); 
      $countSoal   = count($dataSoalQuiz);
      $dataQuiz = DB::table('quizs')                  
                 ->join('moduls', 'quizs.id_modul', '=', 'moduls.id_modul')
                 ->select('quizs.*', 'moduls.nama_modul')
                 ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                 ->get(); 
      $countQuiz   = count($dataQuiz);
      return view('admin.dashboard.index.main_trainer')             
             ->with('countMateriModul', $countMateriModul)
             ->with('countTugas', $countTugas)
             ->with('countSoal', $countSoal)
             ->with('countQuiz', $countQuiz);     
    }

  public function dashBoardLevel13(){  
      $trainee = Trainee::where('id_user', Auth::user()->id_user)->first();        
      $departemen_trainee = Departemen::where('nama_departemen', $trainee->departemen_trainee)->get();

      $dataMateriModul = DB::table('materi_moduls')                                                          
         ->join('moduls', 'materi_moduls.id_modul', '=', 'moduls.id_modul')       
         ->select('materi_moduls.*', 'moduls.nama_modul')
         // ->where('materi_moduls.materi_departemen', $trainee->departemen_trainee)
         ->where('materi_moduls.materi_departemen', $trainee->departemen_trainee)
         ->get();      
      $countMateriModul   = count($dataMateriModul);
      $dataTugas = DB::table('tugass')
                 ->join('moduls', 'tugass.id_modul', '=', 'moduls.id_modul')
                 ->select('tugass.*', 'moduls.nama_modul')
                 ->where('tugass.departemen_tugas', $trainee->departemen_trainee)
                 ->get();
      $countTugas   = count($dataTugas);
      $dataQuiz = DB::table('quizs')                  
                 ->join('moduls', 'quizs.id_modul', '=', 'moduls.id_modul')
                 ->select('quizs.*', 'moduls.nama_modul')
                 ->where('departemen_quiz', $trainee->departemen_trainee)
                 ->where('status_quiz', 'Aktif')
                 ->get();
      $countQuiz   = count($dataQuiz);
      $countPengumuman   = Pengumuman::count();      
      return view('admin.dashboard.index.main_trainee')
            ->with('countMateriModul', $countMateriModul)
            ->with('countTugas', $countTugas)
            ->with('countQuiz', $countQuiz)            
            ->with('countPengumuman', $countPengumuman);     
    }   

}