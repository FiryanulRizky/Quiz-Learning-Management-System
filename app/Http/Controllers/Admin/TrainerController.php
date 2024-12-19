<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use Auth;
use DB;
use Session;
use Validator;
use App\Http\Controllers\Controller;
use App\Trainer as Trainer;
use App\User as User;

class TrainerController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function showTambahTrainer()
  {
  	$idUser= User::select(DB::raw("id_user, username"))
        ->orderBy(DB::raw("id_user"))        
        ->get();
    return view('admin.dashboard.trainer.tambah_trainer')
    		->with('listIduser', $idUser);
  }

  public function detail($nik_trainer)
  {
    $data = Trainer::find($nik_trainer);
    $trainer = Trainer::orderBy('nik_trainer')->get();
    $user= User::select(DB::raw("id_user, username, password"))
            ->orderBy(DB::raw("id_user"))        
            ->get();    

    return view('admin.dashboard.trainer.detail_trainer',$data)
            ->with('trainer', $trainer)
            ->with('userData', $user);
  }

  public function detail_trainer($nik_trainer)
  {
    $data = Trainer::find($nik_trainer);
    $trainer = Trainer::orderBy('nik_trainer')->get();
    $user= User::select(DB::raw("id_user, username, password"))
            ->orderBy(DB::raw("id_user"))        
            ->get();    

    return view('admin.dashboard.trainer.detail_trainer',$data)
            ->with('trainer', $trainer)
            ->with('userData', $user);
  }

  public function index()
  {
    $dataTrainer = Trainer::select(DB::raw("nik_trainer,nama_trainer,ttl_trainer,jns_kelamin_trainer,agama_trainer,no_telp_trainer,email_trainer,alamat_trainer,jabatan_trainer,foto_trainer,status_trainer, id_user"))
        ->orderBy(DB::raw("nik_trainer"))        
        ->get();
        
    $data = array('trainer' => $dataTrainer);   
    return view('admin.dashboard.trainer.trainer',$data);
  }    

  public function hapus($nik_trainer)
  {
  
    $nik_trainer = Trainer::where('nik_trainer', '=', $nik_trainer)->first();

    if ($nik_trainer == null)
      app::abort(404);
    
    Session::flash('flash_message', 'Data Trainer "'.$nik_trainer->nik_trainer.'" - "'.$nik_trainer->nama_trainer.'" Berhasil dihapus.');
    $image_path = public_path().'/upload_gambar/'.$nik_trainer->foto_trainer;
    $nik_trainer->delete();
    unlink($image_path);
    return Redirect::action('Admin\TrainerController@index');

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
            'nik_trainer.required' 		=> 'nip trainer dibutuhkan.',
            'nama_trainer.required' 		=> 'nama trainer dibutuhkan.',
            'ttl_trainer.required' 		=> 'ttl trainer dibutuhkan.', 
            'jns_kelamin_trainer.required' => 'jenis kelamin trainer dibutuhkan.',
            'agama_trainer.required' 		=> 'agama trainer dibutuhkan.',
            'no_telp_trainer.required' 	=> 'no telp trainer dibutuhkan.', 
            'email_trainer.required' 		=> 'email trainer dibutuhkan.',
            'alamat_trainer.required' 		=> 'alamat trainer dibutuhkan.',
            'jabatan_trainer.required' 	=> 'jabatan trainer dibutuhkan.', 
            'foto_trainer.required' 		=> 'foto trainer dibutuhkan.',
            'status_trainer.required' 		=> 'status trainer dibutuhkan.',   
            'id_user.required' 				=> 'id user dibutuhkan.',       
        );

        $aturan = array(
            'nik_trainer'      	=> 'required|numeric',
            'nama_trainer'  		=> 'required',
            'ttl_trainer'     		=> 'required',
            'jns_kelamin_trainer' 	=> 'required',
            'agama_trainer'        => 'required',
            'no_telp_trainer' 		=> 'required',
            'email_trainer'      	=> 'required',
            'alamat_trainer'  		=> 'required',
            'jabatan_trainer'     	=> 'required',
            'foto_trainer'      	=> 'required|image:png,gif,jpeg,jpg',
            'status_trainer'  		=> 'required', 
            'id_user'			=> 'required',         
        );
        

        $validator = Validator::make($input,$aturan, $pesan);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses
        $foto_trainer = $request->file('foto_trainer');
        $namaFotoTrainer = $foto_trainer->getClientOriginalName();
        $request->file('foto_trainer')->move('upload_gambar', $namaFotoTrainer);

        $trainer = new Trainer;
        $trainer->nik_trainer     	= $request['nik_trainer'];
        $trainer->nama_trainer     	= $request['nama_trainer'];
        $trainer->ttl_trainer     	= $request['ttl_trainer'];
        $trainer->jns_kelamin_trainer = $request['jns_kelamin_trainer'];
        $trainer->agama_trainer     	= $request['agama_trainer'];
        $trainer->no_telp_trainer   	= $request['no_telp_trainer'];
        $trainer->email_trainer     	= $request['email_trainer'];
        $trainer->alamat_trainer      = $request['alamat_trainer'];
        $trainer->jabatan_trainer     = $request['jabatan_trainer'];        
        $trainer->foto_trainer        = $namaFotoTrainer;              
        $trainer->status_trainer      = $request['status_trainer'];                     
        $trainer->id_user 			= $request['id_user'];

        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $trainer->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data Trainer "'.$request['nik_trainer'].'" - " '.$request['nama_trainer'].'" Berhasil disimpan.');

        return Redirect::action('Admin\TrainerController@index');
  }  

 public function edittrainer($nik_trainer)
    {
        $data = Trainer::find($nik_trainer);
        $trainer = Trainer::orderBy('nik_trainer')->get();
        $user= User::select(DB::raw("id_user, username"))
		        ->orderBy(DB::raw("id_user"))        
		        ->get();
        return view('admin.dashboard.trainer.edit_trainer',$data)
                ->with('userData', $user);
    }

 public function simpanedit(Request $request, $nik_trainer)
    {
        $input =$request->all();
        $messages = [
            'nik_trainer.required' 		=> 'nip trainer dibutuhkan.',
            'nama_trainer.required' 		=> 'nama trainer dibutuhkan.',
            'ttl_trainer.required' 		=> 'ttl trainer dibutuhkan.', 
            'jns_kelamin_trainer.required' => 'jenis kelamin trainer dibutuhkan.',
            'agama_trainer.required' 		=> 'agama trainer dibutuhkan.',
            'no_telp_trainer.required' 	=> 'no telp trainer dibutuhkan.', 
            'email_trainer.required' 		=> 'email trainer dibutuhkan.',
            'alamat_trainer.required' 		=> 'alamat trainer dibutuhkan.',
            'jabatan_trainer.required' 	=> 'jabatan trainer dibutuhkan.', 
            'foto_trainer.required' 		=> 'foto trainer dibutuhkan.',
            'status_trainer.required' 		=> 'status trainer dibutuhkan.',  
            'id_user.required' 				=> 'id user dibutuhkan.',         
        ];
        

        $validator = Validator::make($input, [
 			'nik_trainer'      	=> 'required|numeric',
            'nama_trainer'  		=> 'required',
            'ttl_trainer'     		=> 'required',
            'jns_kelamin_trainer' 	=> 'required',
            'agama_trainer'        => 'required',
            'no_telp_trainer' 		=> 'required',
            'email_trainer'      	=> 'required',
            'alamat_trainer'  		=> 'required',
            'jabatan_trainer'     	=> 'required',
            'foto_trainer'      	=> 'sometimes|image:png,gif,jpeg,jpg',
            'status_trainer'  		=> 'required', 
            'id_user'			=> 'required',
        ], $messages);
                     

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();          
        }
        # Bila validasi sukses
        $trainer = Trainer::findOrFail($nik_trainer);

        // cek apakah ada file baru di form ?
        if ($request->hasFile('foto_trainer')) {
        $foto_trainer = $input['foto_trainer'];        
        $namaFotoTrainer = $foto_trainer->getClientOriginalName();
        
        // cek pada atribut trainer, jika ada maka hapus file lama
        if (!$trainer->foto_trainer == "") {
          // hapus file lama
          // $image_path = public_path().'/upload_gambar/'.$trainer->foto_trainer;
          // unlink($image_path);
        }          

          // upload file baru
          $input['foto_trainer']->move('upload_gambar', $namaFotoTrainer);
          // save data ke tabel dengan file baru
          $editTrainer = Trainer::find($nik_trainer);
          $editTrainer->nik_trainer         = $input['nik_trainer'];
          $editTrainer->nama_trainer        = $input['nama_trainer'];
          $editTrainer->ttl_trainer         = $input['ttl_trainer'];
          $editTrainer->jns_kelamin_trainer = $input['jns_kelamin_trainer'];
          $editTrainer->agama_trainer       = $input['agama_trainer'];
          $editTrainer->no_telp_trainer     = $input['no_telp_trainer'];
          $editTrainer->email_trainer       = $input['email_trainer'];
          $editTrainer->alamat_trainer      = $input['alamat_trainer'];
          $editTrainer->jabatan_trainer     = $input['jabatan_trainer'];
          $editTrainer->foto_trainer        = $namaFotoTrainer;
          $editTrainer->status_trainer      = $input['status_trainer'];              
          $editTrainer->id_user          = $input['id_user'];
        } else {
          // save data ke tabel tanpa merubah dan menghapus file lama
          // $foto_trainer = $trainee->foto_trainer;                   
          $editTrainer = Trainer::find($nik_trainer);
          $editTrainer->nik_trainer         = $input['nik_trainer'];
          $editTrainer->nama_trainer        = $input['nama_trainer'];
          $editTrainer->ttl_trainer         = $input['ttl_trainer'];
          $editTrainer->jns_kelamin_trainer = $input['jns_kelamin_trainer'];
          $editTrainer->agama_trainer       = $input['agama_trainer'];
          $editTrainer->no_telp_trainer     = $input['no_telp_trainer'];
          $editTrainer->email_trainer       = $input['email_trainer'];
          $editTrainer->alamat_trainer      = $input['alamat_trainer'];
          $editTrainer->jabatan_trainer     = $input['jabatan_trainer'];            
          $editTrainer->status_trainer      = $input['status_trainer'];              
          $editTrainer->id_user          = $input['id_user']; 
        }          

        if (! $editTrainer->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Trainer "'.$input['nik_trainer'].'" dengan nama" '.$input['nama_trainer'].'" Berhasil diubah.');

        return Redirect::action('Admin\TrainerController@index'); 
    }

 public function edit_asTrainer()
{    
    $data = Trainer::where('id_user', Auth::user()->id_user)->first(); 
    // $data = Trainer::find($trainer->nik_trainer);
    // dd($trainer, $data);
    $user= User::select(DB::raw("id_user, username"))
        ->orderBy(DB::raw("id_user"))        
        ->get();
    return view('admin.dashboard.trainer.edit_trainer',$data)
            ->with('userData', $user);
}

 public function simpanedit_asTrainer(Request $request)
    {
        $input =$request->all();
        $messages = [
            'nik_trainer.required'     => 'nip trainer dibutuhkan.',
            'nama_trainer.required'    => 'nama trainer dibutuhkan.',
            'ttl_trainer.required'     => 'ttl trainer dibutuhkan.', 
            'jns_kelamin_trainer.required' => 'jenis kelamin trainer dibutuhkan.',
            'agama_trainer.required'     => 'agama trainer dibutuhkan.',
            'no_telp_trainer.required'   => 'no telp trainer dibutuhkan.', 
            'email_trainer.required'     => 'email trainer dibutuhkan.',
            'alamat_trainer.required'    => 'alamat trainer dibutuhkan.',
            'jabatan_trainer.required'   => 'jabatan trainer dibutuhkan.', 
            'foto_trainer.required'    => 'foto trainer dibutuhkan.',
            'status_trainer.required'    => 'status trainer dibutuhkan.',  
            // 'id_user.required'        => 'id user dibutuhkan.',         
        ];
        

        $validator = Validator::make($input, [
            'nik_trainer'        => 'required|numeric',
            'nama_trainer'     => 'required',
            'ttl_trainer'        => 'required',
            'jns_kelamin_trainer'  => 'required',
            'agama_trainer'        => 'required',
            'no_telp_trainer'    => 'required',
            'email_trainer'        => 'required',
            'alamat_trainer'     => 'required',
            'jabatan_trainer'      => 'required',
            'foto_trainer'       => 'sometimes|image:png,gif,jpeg,jpg',
            'status_trainer'     => 'required', 
            // 'id_user'     => 'required',
        ], $messages);
                     

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();          
        }
        # Bila validasi sukses
        $trainer = Trainer::findOrFail($input['nik_trainer']);

        // cek apakah ada file baru di form ?
        if ($request->hasFile('foto_trainer')) {
        $foto_trainer = $input['foto_trainer'];        
        $namaFotoTrainer = $foto_trainer->getClientOriginalName();
        
        // cek pada atribut trainer, jika ada maka hapus file lama
        if (!$trainer->foto_trainer == "") {
          // hapus file lama
          // $image_path = public_path().'/upload_gambar/'.$trainer->foto_trainer;
          // unlink($image_path);
        }          

          // upload file baru
          $input['foto_trainer']->move('upload_gambar', $namaFotoTrainer);
          // save data ke tabel dengan file baru
          $editTrainer = Trainer::find($input['nik_trainer']);          
          $editTrainer->nama_trainer        = $input['nama_trainer'];
          $editTrainer->ttl_trainer         = $input['ttl_trainer'];
          $editTrainer->jns_kelamin_trainer = $input['jns_kelamin_trainer'];
          $editTrainer->agama_trainer       = $input['agama_trainer'];
          $editTrainer->no_telp_trainer     = $input['no_telp_trainer'];
          $editTrainer->email_trainer       = $input['email_trainer'];
          $editTrainer->alamat_trainer      = $input['alamat_trainer'];
          $editTrainer->jabatan_trainer     = $input['jabatan_trainer'];
          $editTrainer->foto_trainer        = $namaFotoTrainer; 
        } else {
          // save data ke tabel tanpa merubah dan menghapus file lama
          // $foto_trainer = $trainee->foto_trainer;                   
          $editTrainer = Trainer::find($input['nik_trainer']);          
          $editTrainer->nama_trainer        = $input['nama_trainer'];
          $editTrainer->ttl_trainer         = $input['ttl_trainer'];
          $editTrainer->jns_kelamin_trainer = $input['jns_kelamin_trainer'];
          $editTrainer->agama_trainer       = $input['agama_trainer'];
          $editTrainer->no_telp_trainer     = $input['no_telp_trainer'];
          $editTrainer->email_trainer       = $input['email_trainer'];
          $editTrainer->alamat_trainer      = $input['alamat_trainer'];
          $editTrainer->jabatan_trainer     = $input['jabatan_trainer'];           
        }          

        if (! $editTrainer->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Trainer "'.$input['nik_trainer'].'" dengan nama" '.$input['nama_trainer'].'" Berhasil diubah.');

        return redirect('trainer/trainer/'.$input['nik_trainer'].'/detail'); 
    }
  
}


