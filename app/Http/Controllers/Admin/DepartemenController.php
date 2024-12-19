<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use DB;
use Auth;
use Validator;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DepartemenHaveModul as Departemen;
use App\Trainer as Trainer;
use App\Modul as Modul;

class DepartemenController extends Controller
{
 
  public function showTambahDepartemen()
  {
  	$idModul_learn= Modul::select(DB::raw("id_modul, nama_modul"))
        ->orderBy(DB::raw("id_modul"))        
        ->get();
    return view('admin.dashboard.departemen.tambah_departemen')
    		->with('Modul_learn', $idModul_learn);
  }

  public function index()
  {
    $dataDepartemen = DB::table('departemen_have_moduls')                  
                 ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                 ->select('departemen_have_moduls.*', 'moduls.nama_modul')
                 ->orderBy('departemen_have_moduls.nama_departemen', 'asc')->get();         
    $data = array('departemen' => $dataDepartemen);   
    return view('admin.dashboard.departemen.departemen',$data);
  }   

  public function index_trainer()
  {
    $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();
    $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
    $dataDepartemen = DB::table('departemen_have_moduls')                  
                 ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                 ->select('departemen_have_moduls.*', 'moduls.nama_modul')
                 ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
                 ->orderBy('departemen_have_moduls.nama_departemen', 'asc')->get();         
    $data = array('departemen' => $dataDepartemen);   
    return view('admin.dashboard.departemen.departemen',$data);
  }     

  public function hapus($id)
  {
  
    $departemen = Departemen::where('id', '=', $id)->first();

    if ($departemen == null)
      app::abort(404);
    
    Session::flash('flash_message', 'Data Departemen "'.$departemen->nama_departemen.'" - "'.$departemen->id_modul.'" Berhasil dihapus.');

    $departemen->delete();
    
    return Redirect::action('Admin\DepartemenController@index');

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
            'nama_departemen.required' => 'Judul dibutuhkan.',
            'id_modul.required' => 'Deskripsi dibutuhkan.',                    
        );

        $aturan = array(
            'nama_departemen'=> 'required',
            'id_modul'  => 'required',           
        );        
        $validator = Validator::make($input,$aturan, $pesan);        
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // revisi
        $dataDepartemen = Departemen::all();
        foreach ($dataDepartemen as $data) {
          if ($data->nama_departemen == $request['nama_departemen'] && $data->id_modul == $request['id_modul']) {
            Session::flash('flash_message', 'Data Departemen dan modul sudah ada. Periksa Kembali !!!');
            return Redirect::back()->withInput();
          }
        }

        $departemen = new Departemen;
        $departemen->nama_departemen     	= $request['nama_departemen'];
        $departemen->id_modul 		= $request['id_modul'];      

        if (! $departemen->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data Departemen "'.$request['nama_departemen'].'" - " '.$request['id_modul'].'" Berhasil disimpan.');

        return Redirect::action('Admin\DepartemenController@index');
  }  

 public function editdepartemen($id)
    {
        $data = Departemen::find($id);        
        $idModul_learn= Modul::select(DB::raw("id_modul, nama_modul"))
        ->orderBy(DB::raw("id_modul"))        
        ->get();
        return view('admin.dashboard.departemen.edit_departemen',$data)
                ->with('Modul_learn', $idModul_learn);
    }

 public function simpanedit(Request $request, $id)
    {
        $input =$request->all();
        $messages = [
            'nama_departemen.required' => 'Judul dibutuhkan.',
            'id_modul.required' => 'Deskripsi dibutuhkan.',           
        ];        

        $validator = Validator::make($input, [
            'nama_departemen'  => 'required',
            'id_modul'  => 'required',
        ], $messages);
                     

        if($validator->fails()) {        
            return Redirect::back()->withErrors($validator)->withInput();          
        }
         
        $editDepartemen = Departemen::find($id);
        $editDepartemen->nama_departemen     = $input['nama_departemen'];
        $editDepartemen->id_modul = $input['id_modul'];     

        if (! $editDepartemen->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Departemen "'.$input['nama_departemen'].'" id modul_learn " '.$input['id_modul'].'" Berhasil diubah.');

        return Redirect::action('Admin\DepartemenController@index'); 
    }
}
