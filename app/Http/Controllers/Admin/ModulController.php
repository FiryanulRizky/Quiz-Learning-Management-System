<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use DB;

use Validator;
use App\Http\Controllers\Controller;
use App\Modul as Modul;
use App\Trainer as Trainer;
use Session;

class ModulController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function showTambahModul()
  {
    $idTrainer= Trainer::select(DB::raw("nik_trainer, nama_trainer"))
        ->orderBy(DB::raw("nik_trainer"))        
        ->get();
    return view('admin.dashboard.modul.tambah_modul')
        ->with('Trainer', $idTrainer);
  }

  public function index()
  {

    $dataModul_learn = DB::table('moduls')                             
                 ->join('trainers', 'moduls.nik_trainer', '=', 'trainers.nik_trainer')
                 ->select('moduls.*', 'trainers.nama_trainer')
                 ->get();           
        
    $data = array('modul' => $dataModul_learn);    
    return view('admin.dashboard.modul.modul',$data);
  }    

  public function hapus($id_modul)
  {
  
    $id_modul = Modul::where('id_modul', '=', $id_modul)->first();

    if ($id_modul == null)
      app::abort(404);
    
    Session::flash('flash_message', 'Data Modul  "'.$id_modul->id_modul.'" - "'.$id_modul->nama_modul.'" Berhasil dihapus.');

    $id_modul->delete();
    
    return Redirect::action('Admin\ModulController@index');

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
            'nama_modul.required'     => 'Nama Modul dibutuhkan.',
            'nik_trainer.required'     => 'NIK Trainer dibutuhkan.',
        );

        $aturan = array(
            'nama_modul' => 'required',           
            'nik_trainer' => 'required',
        );
        

        $validator = Validator::make($input,$aturan, $pesan);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses

        $modul_learn = new Modul;
        $modul_learn->nama_modul     = $request['nama_modul'];    
        $modul_learn->nik_trainer     = $request['nik_trainer'];

        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $modul_learn->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data Modul "'.$request['id_modul'].'" - " '.$request['nama_modul'].'" Berhasil disimpan.');

        return Redirect::action('Admin\ModulController@index');
  }  

 public function editmodul_learn($id_modul)
    {
        $idTrainer = Trainer::select(DB::raw("nik_trainer, nama_trainer"))
          ->orderBy(DB::raw("nik_trainer"))        
          ->get();

        $data = Modul::find($id_modul);
        $modul = Modul::orderBy('id_modul')->get();

        return view('admin.dashboard.modul.edit_modul',$data)
                ->with('Trainer', $idTrainer)
                ->with('list_modul', $modul);
    }

  public function simpanedit(Request $request, $id_modul)
    {
        $input =$request->all();
        $messages = [
            'nama_modul.required'     => 'Nama Modul dibutuhkan.',
            'nik_trainer.required'     => 'NIK Trainer dibutuhkan.',
        ];        

        $validator = Validator::make($input, [
            'nama_modul' => 'required',           
            'nik_trainer' => 'required',
        ], $messages);
                     

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();          
        }
        # Bila validasi sukses        
        $editModul_learn = Modul::find($id_modul);
        $editModul_learn->nama_modul        = $input['nama_modul'];  
        $editModul_learn->nik_trainer     = $input['nik_trainer'];       

        if (! $editModul_learn->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Nama Modul " '.$input['nama_modul'].'" Berhasil diubah.');

        return Redirect::action('Admin\ModulController@index'); 
    }
}


