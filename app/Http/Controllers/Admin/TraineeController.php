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
use App\User as User;
use Session;

class TraineeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function showTambahTrainee()
  {
  	$idUser= User::select(DB::raw("id_user, username"))
        ->orderBy(DB::raw("id_user"))        
        ->get();
    return view('admin.dashboard.trainee.tambah_trainee')
    		->with('listIduser', $idUser);;
  }

  public function detail($nisn_trainee)
  {
    $data = Trainee::find($nisn_trainee);
    $user= User::select(DB::raw("id_user, username, password"))
    ->orderBy(DB::raw("id_user"))        
    ->get();        
    $trainee = Trainee::orderBy('nisn_trainee')->get();
    
    // $idUserTrainee = '3';
    // $trainee = \App\Trainee::where('id_user', '3')->first(); 
    // dd($trainee->foto_trainee);
    return view('admin.dashboard.trainee.detail_trainee',$data)
            ->with('trainee', $trainee)
            ->with('userData', $user);

    // $dataTrainee = Trainee::select(DB::raw("nisn_trainee,nama_trainee,email_trainee,no_hp_trainee,ttl_trainee,jns_kelamin_trainee,alamat_trainee,departemen_trainee,foto_trainee,status_trainee,id_user"))
    //     ->orderBy(DB::raw("nisn_trainee"))        
    //     ->get();
        
    // $data = array('trainee' => $dataTrainee);   
    // return view('admin.dashboard.trainee.detail_trainee',$data);
  }

  public function detail_trainee($nisn_trainee)
  {
    $data = Trainee::find($nisn_trainee); 
                
    return view('admin.dashboard.trainee.detail_trainee',$data);
            
  }

  public function trainee_detail($nisn_trainee)
  {
    $data = Trainee::find($nisn_trainee);    
    return view('admin.dashboard.trainee.detail_trainee',$data);          
  }

  public function departemen_trainee()
  {
    $trainee = Trainee::where('id_user', Auth::user()->id_user)->first();
    $data = Trainee::where('nisn_trainee',$trainee->nisn_trainee)->first();
    $listTraineeDepartemen = Trainee::where('departemen_trainee', $data->departemen_trainee)->get();
    // dd($listTraineeDepartemen);
    $dataDepartemen = DB::table('departemen_have_moduls')                  
                 ->join('moduls', 'departemen_have_moduls.id_modul', '=', 'moduls.id_modul')
                 ->select('departemen_have_moduls.*', 'moduls.nama_modul')
                 ->where('departemen_have_moduls.nama_departemen', $trainee->departemen_trainee)
                 ->orderBy('departemen_have_moduls.nama_departemen', 'asc')->get(); 

    return view('admin.dashboard.trainee.departemen_trainee',$data)
            ->with('trainee', $listTraineeDepartemen)
            ->with('departemen', $dataDepartemen);
  }

  public function index()
  {
    $dataTrainee = Trainee::select(DB::raw("nisn_trainee,nama_trainee,email_trainee,no_hp_trainee,ttl_trainee,jns_kelamin_trainee,alamat_trainee,departemen_trainee,foto_trainee,status_trainee,id_user"))
        ->orderBy(DB::raw("nisn_trainee"))        
        ->get();
        
    $data = array('trainee' => $dataTrainee);   
    return view('admin.dashboard.trainee.trainee',$data);
  }    

  public function hapus($nisn_trainee)
  { 
  
    $nisn_trainee = Trainee::where('nisn_trainee', '=', $nisn_trainee)->first();

    if ($nisn_trainee == null)
      app::abort(404);
    
    Session::flash('flash_message', 'Data Trainee "'.$nisn_trainee->nisn_trainee.'" - "'.$nisn_trainee->nama_trainee.'" Berhasil dihapus.');
    $image_path = public_path().'/upload_gambar/'.$nisn_trainee->foto_trainee;
    $nisn_trainee->delete();
    unlink($image_path);
    return Redirect::action('Admin\TraineeController@index');

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
            'nisn_trainee.required' 		 	=> 'nisn trainee dibutuhkan.',
            'nama_trainee.required' 			=> 'nama trainee dibutuhkan.',
            'email_trainee.required' 			=> 'email trainee dibutuhkan.', 
            'no_hp_trainee.required' 			=> 'no hp trainee dibutuhkan.',
            'ttl_trainee.required' 			=> 'ttl trainee dibutuhkan.',
            'jns_kelamin_trainee.required' 	=> 'jenis kelamin trainee dibutuhkan.', 
            'alamat_trainee.required' 		=> 'alamat trainee dibutuhkan.',
            'departemen_trainee.required' 			=> 'departemen trainee dibutuhkan.',
            'foto_trainee.required' 			=> 'foto trainee dibutuhkan.', 
            'status_trainee.required' 		=> 'status trainee dibutuhkan.',
            'id_user.required' 				=> 'id user dibutuhkan.',       
                     
        );

        $aturan = array(
            'nisn_trainee'      	=> 'required|numeric',
            'nama_trainee'  		=> 'required',
            'email_trainee'     	=> 'required',
            'no_hp_trainee'       => 'required',
            'ttl_trainee'         => 'required',
            'jns_kelamin_trainee' => 'required',
            'alamat_trainee'      => 'required',
            'departemen_trainee'  		=> 'required',
            'foto_trainee'     	=> 'required|image:png,gif,jpeg,jpg',
            'status_trainee'      => 'required',
            // 'id_user'  			=> 'required',                      
        );
        

        $validator = Validator::make($input,$aturan, $pesan);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses                        

        $foto_trainee = $request->file('foto_trainee');         
        $namaFotoTrainee = $foto_trainee->getClientOriginalName();
        $request->file('foto_trainee')->move('upload_gambar', $namaFotoTrainee);

        $trainee = new Trainee;
        $trainee->nisn_trainee     		= $request['nisn_trainee'];
        $trainee->nama_trainee     		= $request['nama_trainee'];
        $trainee->email_trainee     	= $request['email_trainee'];
        $trainee->no_hp_trainee     	= $request['no_hp_trainee'];
        $trainee->ttl_trainee     		= $request['ttl_trainee'];
        $trainee->jns_kelamin_trainee   = $request['jns_kelamin_trainee'];
        $trainee->alamat_trainee     	= $request['alamat_trainee'];
        $trainee->departemen_trainee     	= $request['departemen_trainee'];
        $trainee->foto_trainee     		= $namaFotoTrainee;
        $trainee->status_trainee     	= $request['status_trainee'];
        $trainee->id_user     		= $request['id_user'];   
                    
        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $trainee->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data Trainee "'.$request['nisn_trainee'].'" - " '.$request['nama_trainee'].'" Berhasil disimpan.');

        return Redirect::action('Admin\TraineeController@index');
  }  

 public function edittrainee($nisn_trainee)
    {
        $data = Trainee::find($nisn_trainee);
        $user= User::select(DB::raw("id_user, username"))
        ->orderBy(DB::raw("id_user"))        
        ->get();        
        $trainee = Trainee::orderBy('nisn_trainee')->get();

        return view('admin.dashboard.trainee.edit_trainee',$data)
                ->with('list_trainee', $trainee)
                ->with('userData', $user);
    }

 public function simpanedit(Request $request, $nisn_trainee)
    {
        $input =$request->all();
        // dd($input);
        $messages = [
            'nisn_trainee.required' 		 	=> 'nisn trainee dibutuhkan.',
            'nama_trainee.required' 			=> 'nama trainee dibutuhkan.',
            'email_trainee.required' 			=> 'email trainee dibutuhkan.', 
            'no_hp_trainee.required' 			=> 'no hp trainee dibutuhkan.',
            'ttl_trainee.required' 			=> 'ttl trainee dibutuhkan.',
            'jns_kelamin_trainee.required' 	=> 'jenis kelamin trainee dibutuhkan.', 
            'alamat_trainee.required' 		=> 'alamat trainee dibutuhkan.',
            'departemen_trainee.required' 			=> 'departemen trainee dibutuhkan.',
            'foto_trainee.required' 			=> 'foto trainee dibutuhkan.', 
            'status_trainee.required' 		=> 'status trainee dibutuhkan.',
            // 'id_user.required' 				=> 'id user dibutuhkan.',                                          
        ];
        
        $validator = Validator::make($input, [
 			'nisn_trainee'      	=> 'required|numeric',
            'nama_trainee'  		=> 'required',
            'email_trainee'     	=> 'required',
            'no_hp_trainee'       => 'required',
            'ttl_trainee'         => 'required',
            'jns_kelamin_trainee' => 'required',
            'alamat_trainee'      => 'required',
            'departemen_trainee'  		=> 'required',
            'foto_trainee'     	=> 'sometimes|image:png,gif,jpeg,jpg',
            'status_trainee'      => 'required',
            // 'id_user'  			=> 'required',                        
        ], $messages);                             

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses

        $trainee = Trainee::findOrFail($nisn_trainee);
        // cek apakah ada file baru di form ?
        if ($request->hasFile('foto_trainee')) {
          $foto_trainee = $input['foto_trainee'];        
          $namaFotoTrainee = $foto_trainee->getClientOriginalName();
                  
          // hapus file lama
          // $image_path = public_path().'/upload_gambar/'.$trainee->foto_trainee;
          // unlink($image_path);        

          // upload file baru
          $input['foto_trainee']->move('upload_gambar', $namaFotoTrainee);
          // save data ke tabel dengan file baru
          $editTrainee = Trainee::find($nisn_trainee);
          $editTrainee->nisn_trainee          = $input['nisn_trainee'];
          $editTrainee->nama_trainee          = $input['nama_trainee'];
          $editTrainee->email_trainee         = $input['email_trainee'];
          $editTrainee->no_hp_trainee         = $input['no_hp_trainee'];
          $editTrainee->ttl_trainee           = $input['ttl_trainee'];
          $editTrainee->jns_kelamin_trainee   = $input['jns_kelamin_trainee'];
          $editTrainee->alamat_trainee        = $input['alamat_trainee'];
          $editTrainee->departemen_trainee         = $input['departemen_trainee'];
          $editTrainee->foto_trainee          = $namaFotoTrainee;
          $editTrainee->status_trainee        = $input['status_trainee'];
          $editTrainee->id_user             = $input['id_user'];
        } else {
          // save data ke tabel tanpa merubah dan menghapus file lama
          $foto_trainee = $trainee->foto_trainee;
          
          $editTrainee = Trainee::find($nisn_trainee);
          $editTrainee->nisn_trainee          = $input['nisn_trainee'];
          $editTrainee->nama_trainee          = $input['nama_trainee'];
          $editTrainee->email_trainee         = $input['email_trainee'];
          $editTrainee->no_hp_trainee         = $input['no_hp_trainee'];
          $editTrainee->ttl_trainee           = $input['ttl_trainee'];
          $editTrainee->jns_kelamin_trainee   = $input['jns_kelamin_trainee'];
          $editTrainee->alamat_trainee        = $input['alamat_trainee'];
          $editTrainee->departemen_trainee         = $input['departemen_trainee'];          
          $editTrainee->status_trainee        = $input['status_trainee'];
          $editTrainee->id_user             = $input['id_user']; 
        }        
        
        if (! $editTrainee->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Trainee "'.$input['nisn_trainee'].'" dengan nama" '.$input['nama_trainee'].'" Berhasil diubah.');

        return Redirect::action('Admin\TraineeController@index'); 
    }

// trainee
public function edit_asTrainee()
    {   
        $trainee = Trainee::where('id_user', Auth::user()->id_user)->first();        
        $data = Trainee::find($trainee->nisn_trainee);   

        $user= User::select(DB::raw("id_user, username"))
        ->orderBy(DB::raw("id_user"))        
        ->get();        

        return view('admin.dashboard.trainee.edit_trainee',$data)
                ->with('userData', $user);
    }

 public function simpanedit_asTrainee(Request $request)
    {

        $input =$request->all();
        // dd($input);
        $messages = [
            'nisn_trainee.required'       => 'nisn trainee dibutuhkan.',
            'nama_trainee.required'       => 'nama trainee dibutuhkan.',
            'email_trainee.required'      => 'email trainee dibutuhkan.', 
            'no_hp_trainee.required'      => 'no hp trainee dibutuhkan.',
            'ttl_trainee.required'      => 'ttl trainee dibutuhkan.',
            'jns_kelamin_trainee.required'  => 'jenis kelamin trainee dibutuhkan.', 
            'alamat_trainee.required'     => 'alamat trainee dibutuhkan.',
            'departemen_trainee.required'      => 'departemen trainee dibutuhkan.',
            'foto_trainee.required'       => 'foto trainee dibutuhkan.', 
            'status_trainee.required'     => 'status trainee dibutuhkan.',
            // 'id_user.required'         => 'id user dibutuhkan.',                                          
        ];
        
        $validator = Validator::make($input, [
      'nisn_trainee'        => 'required|numeric',
            'nama_trainee'      => 'required',
            'email_trainee'       => 'required',
            'no_hp_trainee'       => 'required',
            'ttl_trainee'         => 'required',
            'jns_kelamin_trainee' => 'required',
            'alamat_trainee'      => 'required',
            'departemen_trainee'     => 'required',
            'foto_trainee'      => 'sometimes|image:png,gif,jpeg,jpg',
            'status_trainee'      => 'required',
            // 'id_user'        => 'required',                        
        ], $messages);                             

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses

        $trainee = Trainee::findOrFail($input['nisn_trainee']);
        // cek apakah ada file baru di form ?
        if ($request->hasFile('foto_trainee')) {
          $foto_trainee = $input['foto_trainee'];        
          $namaFotoTrainee = $foto_trainee->getClientOriginalName();
          
          // cek pada atribut trainee, jika ada maka hapus file lama
        if (!$trainee->foto_trainee == "") {
          // hapus file lama
          // $image_path = public_path().'/upload_gambar/'.$trainee->foto_trainee;
          // unlink($image_path);        
        }                   

          // upload file baru
          $input['foto_trainee']->move('upload_gambar', $namaFotoTrainee);
          // save data ke tabel dengan file baru
          $editTrainee = Trainee::find($input['nisn_trainee']);
          $editTrainee->nama_trainee          = $input['nama_trainee'];
          $editTrainee->email_trainee         = $input['email_trainee'];
          $editTrainee->no_hp_trainee         = $input['no_hp_trainee'];
          $editTrainee->ttl_trainee           = $input['ttl_trainee'];
          $editTrainee->jns_kelamin_trainee   = $input['jns_kelamin_trainee'];
          $editTrainee->alamat_trainee        = $input['alamat_trainee'];
          $editTrainee->departemen_trainee         = $input['departemen_trainee'];
          $editTrainee->foto_trainee          = $namaFotoTrainee;
        } else {
          // save data ke tabel tanpa merubah dan menghapus file lama
          // $foto_trainee = $trainee->foto_trainee;
          
          $editTrainee = Trainee::find($input['nisn_trainee']);
          $editTrainee->nama_trainee          = $input['nama_trainee'];
          $editTrainee->email_trainee         = $input['email_trainee'];
          $editTrainee->no_hp_trainee         = $input['no_hp_trainee'];
          $editTrainee->ttl_trainee           = $input['ttl_trainee'];
          $editTrainee->jns_kelamin_trainee   = $input['jns_kelamin_trainee'];
          $editTrainee->alamat_trainee        = $input['alamat_trainee'];
          $editTrainee->departemen_trainee         = $input['departemen_trainee'];                   
        }        
        
        if (! $editTrainee->save())
          App::abort(500);

        Session::flash('flash_message', 'Data kamu " '.$input['nama_trainee'].' " Berhasil diubah.');

        return redirect('trainee/trainee/'.$input['nisn_trainee'].'/detail'); 
    }

    // Forum
    
}

