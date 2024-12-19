<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use DB;
use Auth;

use Validator;
use App\Http\Controllers\Controller;
use App\Trainee as Trainee;
use App\Trainer as Trainer;
use App\MateriAjar as MateriAjar;
use App\Modul as Modul;
use App\DepartemenHaveModul as Departemen;
use Session;

class MateriAjarController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function download($id_materi_ajar)
  {
    $data = MateriAjar::find($id_materi_ajar); 
    $file = public_path()."/upload_file/".$data->materi_nama;  
    $headers = array('Content-Type: application/pdf','Content-Type: application/doc', 'Content-Type: application/docx');
    return Response::download($file, $data->materi_nama,$headers);
  }

  public function download_trainee($id_materi_ajar)
  {
    $data = MateriAjar::find($id_materi_ajar); 
    $file = public_path()."/upload_file/".$data->materi_nama;  
    $headers = array('Content-Type: application/pdf','Content-Type: application/doc', 'Content-Type: application/docx');
    return Response::download($file, $data->materi_nama,$headers);
  }

  public function download_trainer($id_materi_ajar)
  {
    $data = MateriAjar::find($id_materi_ajar); 
    $file = public_path()."/upload_file/".$data->materi_nama;  
    $headers = array('Content-Type: application/pdf','Content-Type: application/doc', 'Content-Type: application/docx');
    return Response::download($file, $data->materi_nama,$headers);
  }

  public function showTambahMateriAjar()
  {
  	 $dataModul_learn = Modul::select(DB::raw("id_modul, nama_modul"))
        ->orderBy(DB::raw("id_modul"))        
        ->get();
    return view('admin.dashboard.materi_ajar.tambah_materi_ajar')
    		->with('dataModul_learn', $dataModul_learn);
  }

  public function showTambahMateriAjar_trainer()
  {    
    $trainer = Trainer::where('id_user', Auth::user()->id_user)->first(); 
    $dataModul_learn = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
    $dataDepartemen = DB::table('departemen_have_moduls')                  
                 ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                 ->select('departemen_have_moduls.*', 'moduls.nama_modul')
                 ->where('moduls.nama_modul', $dataModul_learn->nama_modul)
                 ->orderBy('departemen_have_moduls.nama_departemen', 'asc')->get();
    return view('admin.dashboard.materi_ajar.tambah_materi_ajar')
          ->with('dataModul_learn', $dataModul_learn)
          ->with('dataDepartemen', $dataDepartemen);
  }

  public function index()
  {
    $dataMateriAjar = DB::table('materi_ajars')                                                          
       ->join('moduls', 'materi_ajars.id_modul', '=', 'moduls.id_modul')       
       ->select('materi_ajars.*', 'moduls.nama_modul')
       ->get();
        // dd($dataMateriAjar);    
    $data = array('materi_ajar' => $dataMateriAjar);   
    return view('admin.dashboard.materi_ajar.materi_ajar',$data);
    	   
  } 

  public function index_trainee()
  {
    $trainee = Trainee::where('id_user', Auth::user()->id_user)->first();        
    $departemen_trainee = Departemen::where('nama_departemen', $trainee->departemen_trainee)->get();
    $dataMateriAjar = DB::table('materi_ajars')                                                          
       ->join('moduls', 'materi_ajars.id_modul', '=', 'moduls.id_modul')       
       ->select('materi_ajars.*', 'moduls.nama_modul')
       // ->where('materi_ajars.materi_departemen', $trainee->departemen_trainee)
       ->where('materi_ajars.materi_departemen', $trainee->departemen_trainee)
       ->get();        
    $data = array('materi_ajar' => $dataMateriAjar);   
    return view('admin.dashboard.materi_ajar.materi_ajar',$data);        
  }

  public function index_trainer()
  {
    $trainer = Trainer::where('id_user', Auth::user()->id_user)->first();        
    $Modul_learnTrainer = Modul::where('nik_trainer', $trainer->nik_trainer)->first();   
    $dataMateriAjar = DB::table('materi_ajars')                                                          
       ->join('moduls', 'materi_ajars.id_modul', '=', 'moduls.id_modul')       
       ->select('materi_ajars.*', 'moduls.nama_modul')
       ->where('moduls.nama_modul', $Modul_learnTrainer->nama_modul)
       ->get();        
    $data = array('materi_ajar' => $dataMateriAjar);   
    return view('admin.dashboard.materi_ajar.materi_ajar',$data);        
  }

  public function hapus($id_materi_ajar)
  {  
    $id_materi_ajar = MateriAjar::where('id_materi_ajar', '=', $id_materi_ajar)->first();
    if ($id_materi_ajar == null)
      app::abort(404);    
    Session::flash('flash_message', 'Data Materi Ajar "'.$id_materi_ajar->materi_judul.'" - "'.$id_materi_ajar->materi_nama.'" Berhasil dihapus.');    
    $image_path = public_path().'/upload_file/'.$id_materi_ajar->materi_nama;     
    $id_materi_ajar->delete();        
    unlink($image_path);
    //File::delete(public_path()."/upload_file/".$id_materi_ajar->materi_nama);    
    return Redirect::action('Admin\MateriAjarController@index');
  }  

  public function hapus_trainer($id_materi_ajar)
  {  
    $id_materi_ajar = MateriAjar::where('id_materi_ajar', '=', $id_materi_ajar)->first();
    if ($id_materi_ajar == null)
      app::abort(404);    
    Session::flash('flash_message', 'Data Materi Ajar "'.$id_materi_ajar->materi_judul.'" - "'.$id_materi_ajar->materi_nama.'" Berhasil dihapus.');    
    $image_path = public_path().'/upload_file/'.$id_materi_ajar->materi_nama;     
    $id_materi_ajar->delete();        
    unlink($image_path);
    //File::delete(public_path()."/upload_file/".$id_materi_ajar->materi_nama);    
    return Redirect::action('Admin\MateriAjarController@index_trainer');
  }  
 
    
  protected function tambah(Request $request)
  {
        $input =$request->all();        
        $pesan = array(
            'materi_judul.required'     => 'Judul Materi  dibutuhkan.',  
            'materi_nama.required'      => 'Nama Materi dibutuhkan.',  
            'materi_departemen.required'      => 'Departemen Materi dibutuhkan.',
            'id_modul.required'       => 'ID Modul dibutuhkan.',                      
        );

        $aturan = array(
            'materi_judul' => 'required',
            'materi_nama'  => 'required|max:20000',
            'materi_departemen'     => 'required',
            'id_modul'     => 'required', 

        );
        

        $validator = Validator::make($input,$aturan, $pesan);        

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses
        $materi_nama = $request->file('materi_nama');
        $materi_nama_file = $materi_nama->getClientOriginalName();
        $request->file('materi_nama')->move('upload_file', $materi_nama_file);

        $materi = new MateriAjar;
        $materi->materi_judul     = $request['materi_judul'];
        $materi->materi_nama = $materi_nama_file;
        $materi->materi_departemen     = $request['materi_departemen'];
        $materi->id_modul    = $request['id_modul'];      

        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $materi->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data Materi Ajar "'.$request['materi_judul'].'" - " '.$materi_nama_file.'" Berhasil disimpan.');

        return Redirect::action('Admin\MateriAjarController@index');
  }  

   protected function tambah_trainer(Request $request)
  {
        $input =$request->all();        
        $pesan = array(
            'materi_judul.required'     => 'Judul Materi  dibutuhkan.',  
            'materi_nama.required'      => 'Nama Materi dibutuhkan.',  
            'materi_departemen.required'      => 'Departemen Materi dibutuhkan.',
            'id_modul.required'       => 'ID Modul dibutuhkan.',                      
        );

        $aturan = array(
            'materi_judul' => 'required',
            'materi_nama'  => 'required|max:20000',
            'materi_departemen'     => 'required',
            'id_modul'     => 'required', 
        );
        

        $validator = Validator::make($input,$aturan, $pesan);        

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses
        $materi_nama = $request->file('materi_nama');
        $materi_nama_file = $materi_nama->getClientOriginalName();
        $request->file('materi_nama')->move('upload_file', $materi_nama_file);

        $materi = new MateriAjar;
        $materi->materi_judul     = $request['materi_judul'];
        $materi->materi_nama = $materi_nama_file;
        $materi->materi_departemen     = $request['materi_departemen'];
        $materi->id_modul    = $request['id_modul'];      

        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $materi->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data Materi Ajar "'.$request['materi_judul'].'" - " '.$materi_nama_file.'" Berhasil disimpan.');

        return Redirect::action('Admin\MateriAjarController@index_trainer');
  } 

 public function editmateri_ajar($id_materi_ajar)
    {
        $data = MateriAjar::find($id_materi_ajar);        
        $dataModul_learn = Modul::select(DB::raw("id_modul, nama_modul"))
        ->orderBy(DB::raw("id_modul"))        
        ->get();        
        return view('admin.dashboard.materi_ajar.edit_materi_ajar',$data)
                ->with('dataModul_learn', $dataModul_learn);
    }
 
 public function editmateri_ajar_trainer($id_materi_ajar)
    {
      $data = MateriAjar::find($id_materi_ajar); 
      $trainer = Trainer::where('id_user', Auth::user()->id_user)->first(); 
      $dataModul_learn = Modul::where('nik_trainer', $trainer->nik_trainer)->first();
      $dataDepartemen = DB::table('departemen_have_moduls')                  
                   ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                   ->select('departemen_have_moduls.*', 'moduls.nama_modul')
                   ->where('moduls.nama_modul', $dataModul_learn->nama_modul)
                   ->orderBy('departemen_have_moduls.nama_departemen', 'asc')->get();
      return view('admin.dashboard.materi_ajar.edit_materi_ajar',$data)
            ->with('dataModul_learn', $dataModul_learn)
            ->with('dataDepartemen', $dataDepartemen);                        
    }

 public function simpanedit(Request $request, $id_materi_ajar)
    {
        $input =$request->all();
        $messages = [
            'materi_judul.required'     => 'Judul Materi  dibutuhkan.',  
            'materi_nama.required'      => 'Nama Materi dibutuhkan.',  
            'materi_departemen.required'      => 'Departemen Materi dibutuhkan.',
            'id_modul.required'       => 'ID Modul dibutuhkan.',          
        ];
        

        $validator = Validator::make($input, [
 			      'materi_judul' => 'required',
            'materi_nama'  => 'sometimes|max:20000',
            'materi_departemen'     => 'required',
            'id_modul'     => 'required', 
        ], $messages);



        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();          
        }
        # Bila validasi sukses        
        
        $materi_ajar = MateriAjar::findOrFail($id_materi_ajar);
        
        // cek apakah ada file baru di form ?
        if ($request->hasFile('materi_nama')) {
          $materi_nama = $input['materi_nama'];
          $materi_nama_file = $materi_nama->getClientOriginalName();        
          
          // hapus file lama
          $image_path = public_path().'/upload_file/'.$materi_ajar->materi_nama;
          unlink($image_path);        

          // upload file baru
          $input['materi_nama']->move('upload_file', $materi_nama_file); 
          // save data ke tabel dengan file baru
          $editMateriAjar = MateriAjar::find($id_materi_ajar);
          $editMateriAjar->materi_judul      = $input['materi_judul'];
          $editMateriAjar->materi_nama        = $materi_nama_file;
          $editMateriAjar->materi_departemen      = $input['materi_departemen'];
          $editMateriAjar->id_modul           = $input['id_modul'];
        } else {
          // save data ke tabel tanpa merubah dan menghapus file lama
          $materi_nama = $materi_ajar->materi_nama;
          
          $editMateriAjar = MateriAjar::find($id_materi_ajar);          
          $editMateriAjar->materi_judul      = $input['materi_judul']; 
          $editMateriAjar->materi_departemen      = $input['materi_departemen'];       
          $editMateriAjar->id_modul           = $input['id_modul']; 
        }                            

        if (! $editMateriAjar->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Materi Ajar "'.$input['materi_judul'].'" Berhasil diubah.');

        return Redirect::action('Admin\MateriAjarController@index'); 
    }


public function simpanedit_trainer(Request $request, $id_materi_ajar)
    {
        $input =$request->all();
        $messages = [
            'materi_judul.required'     => 'Judul Materi  dibutuhkan.',  
            'materi_nama.required'      => 'Nama Materi dibutuhkan.',  
            'materi_departemen.required'      => 'Departemen Materi dibutuhkan.',
            'id_modul.required'       => 'ID Modul dibutuhkan.',          
        ];
        
        $validator = Validator::make($input, [
            'materi_judul' => 'required',
            'materi_nama'  => 'sometimes|max:20000',
            'materi_departemen'     => 'required',
            'id_modul'     => 'required', 
        ], $messages);

        if($validator->fails()) {         
            return Redirect::back()->withErrors($validator)->withInput();          
        }        
        $materi_ajar = MateriAjar::findOrFail($id_materi_ajar);        
        
        if ($request->hasFile('materi_nama')) {
          $materi_nama = $input['materi_nama'];
          $materi_nama_file = $materi_nama->getClientOriginalName();        
          
          // hapus file lama
          $image_path = public_path().'/upload_file/'.$materi_ajar->materi_nama;
          unlink($image_path);        

          // upload file baru
          $input['materi_nama']->move('upload_file', $materi_nama_file); 
          // save data ke tabel dengan file baru
          $editMateriAjar = MateriAjar::find($id_materi_ajar);
          $editMateriAjar->materi_judul      = $input['materi_judul'];
          $editMateriAjar->materi_nama        = $materi_nama_file;
          $editMateriAjar->materi_departemen      = $input['materi_departemen'];
          $editMateriAjar->id_modul           = $input['id_modul'];
        } else {
          // save data ke tabel tanpa merubah dan menghapus file lama
          $materi_nama = $materi_ajar->materi_nama;
          
          $editMateriAjar = MateriAjar::find($id_materi_ajar);          
          $editMateriAjar->materi_judul      = $input['materi_judul']; 
          $editMateriAjar->materi_departemen      = $input['materi_departemen'];       
          $editMateriAjar->id_modul           = $input['id_modul']; 
        }                            

        if (! $editMateriAjar->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Materi Ajar "'.$input['materi_judul'].'" Berhasil diubah.');

        return Redirect::action('Admin\MateriAjarController@index_trainer'); 
    }
}
