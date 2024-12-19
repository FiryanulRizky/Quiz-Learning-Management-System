<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use DB;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Forum as Forum;
use App\Tugas as Tugas;
use App\Trainee as Trainee;
use App\Trainer as Trainer;
use App\Pengumuman as Pengumuman;
use Session;

class ForumController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  // trainer
  public function index_trainer()
  {
    $dataPengumuman = Pengumuman::select(DB::raw("id_pengumuman, judul, deskripsi, author"))
        ->orderBy(DB::raw("id_pengumuman"))        
        ->get();
        
    $data = array('pengumuman' => $dataPengumuman);   
    return view('admin.dashboard.pengumuman.pengumuman',$data);
  }  

  // trainee
  public function index_trainee($id_tugas)
  {    
    $dataTugas = DB::table('tugass')
                 ->join('moduls', 'tugass.id_modul', '=', 'moduls.id_modul')
                 ->select('tugass.*', 'moduls.nama_modul')
                 ->where('id_tugas', $id_tugas)
                 ->first();    
    $dataForum = Forum::where('id_tugas', $id_tugas)->get();

    if (Auth::user()->level == 13) {
        $trainee = Trainee::where('id_user', Auth::user()->id_user)->first();
        $tgl_forum = date('Y-m-d');      
        return view('admin.dashboard.forum.forum_trainee')
            ->with('tgl_forum', $tgl_forum)
            ->with('dataForum', $dataForum)
            ->with('nik_trainee', $trainee->nik_trainee)
            ->with('tugas', $dataTugas);
    }
    if (Auth::user()->level == 12) {
        $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();   
        $tgl_forum = date('Y-m-d');
        return view('admin.dashboard.forum.forum_trainee')
            ->with('tgl_forum', $tgl_forum)
            ->with('dataForum', $dataForum)
            ->with('nik_trainer', $trainer->nik_trainer)
            ->with('tugas', $dataTugas);
    }    
        
  }   
 
  protected function tambah(Request $request)
  {
        $input =$request->all();
        $pesan = array(
            'komentar.required' => 'Isi Dahulu Pesan kamu.',                     
        );

        $aturan = array(
            'komentar'      => 'required'            
        );      
        $validator = Validator::make($input,$aturan, $pesan);        
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses
        $forum = new Forum;
        $forum->id_tugas     = $request['id_tugas'];              
        $forum->nik_trainer     = $request['nik_trainer'];              
        $forum->nik_trainee     = $request['nik_trainee'];              
        $forum->komentar     = $request['komentar'];              
        $forum->tgl_forum     = date('Y-m-d');                           
        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $forum->save() )
          App::abort(500);
        return Redirect::back();
        // return Redirect::action('Admin\ForumController@index_trainee');
  }  
}
