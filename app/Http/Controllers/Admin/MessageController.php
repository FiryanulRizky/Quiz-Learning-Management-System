<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Requests\Message\ValidationRequest;
use App\Message;
use App\Trainee;
use App\Tugas;
use Auth;
use DB;
use Session;
use Redirect;
use App\Http\Controllers\Controller; 

use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 * @copyright Laravel.web.id - 2016
 */
class MessageController extends Controller
{
    /** 
     * Show form for send messae
     */
    public function form()
    {
        $nomorTrainee = Trainee::all();
        
        $data = array('nomorTrainee' => $nomorTrainee);
        // dd($nomorTrainee[0]->no_hp_trainee);
        return view('admin.dashboard.messages.form')
                ->with('no_hp', $nomorTrainee);
    }

    public function edit($id_tugas)
    {
        $nomorTrainee = Trainee::all();
        $tugas = Tugas::find($id_tugas);      
        // dd($tugas);
        $data = array('nomorTrainee' => $nomorTrainee);
        // dd($nomorTrainee[0]->no_hp_trainee);
        $nomor_hp = 'all';
        $nama_kontak = 'All Trainee';
        return view('admin.dashboard.messages.edit', $tugas)
                ->with('no_hp', $nomorTrainee)
                ->with('nomor_hp', $nomor_hp)
                ->with('nama_kontak', $nama_kontak);
    }    

    public function simpanEditTugasAfterSendMessage($id_tugas)
    {                
        # Ubah data sms_status_tugas jadi = Sudah Dikirim
        $editTugas = Tugas::find($id_tugas);
        $editTugas->judul_tugas         = $editTugas->judul_tugas;
        $editTugas->deskripsi_tugas     = $editTugas->deskripsi_tugas;
        $editTugas->departemen_tugas         = $editTugas->departemen_tugas;
        $editTugas->waktu_tugas         = $editTugas->waktu_tugas;
        $editTugas->pembuat_tugas       = $editTugas->pembuat_tugas;
        $editTugas->tgl_tugas           = $editTugas->tgl_tugas;
        $editTugas->info_tugas          = $editTugas->info_tugas;
        $editTugas->status_tugas        = $editTugas->status_tugas;
        $editTugas->sms_status_tugas    = 'Sudah Dikirim';
        $editTugas->id_modul            = $editTugas->id_modul;         

        if (! $editTugas->save())
          App::abort(500);
    }

    // Proses kirim notifikasi ke nomor trainee di dalam departemen
    public function sendEditedMessage(ValidationRequest $request)    
    {        
        // $nomorTrainee = Trainee::orderBy('no_hp_trainee')->get();        
        // dd($request->id_tugas);
        $tugas = Tugas::find($request->id_tugas);        
        $trainee_departemen = DB::table('trainees')
                    ->select('trainees.*')
                    ->where('departemen_trainee', $tugas->departemen_tugas)->get();
        // dd($trainee_departemen);
        if ((string)$request['number'] == 'all') {
            // Kirim ke Semua Nomor Trainee            
            foreach ($trainee_departemen as $no) {            
            abort_if(!function_exists('curl_init'), 400, 'CURL is not installed.');
            $curl = curl_init('http://smsgateway.me/api/v3/messages/send');
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, [
                'email'    => config('smsgateway.email'),
                'password' => config('smsgateway.password'),
                'device'   => config('smsgateway.device'),
                'number'   => $no->no_hp_trainee,
                'name'     => $request->name,
                'message'  => $request->message,
            ]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            // dd($response);
            if (is_null($response)) {
                Session::flash('flash_message', 'SMS Pemberitahuan ke seluruh trainee "Gagal Terkirim" karena Server dan Modem Gateway anda tidak Terhubung, Periksa Kembali Koneksinya');
                return Redirect::back();
            }
            // jika sukses terkirim save ke database
            if ($response->success == true) {
                if (!empty($response->result->fails)) {                    
                    \Log::debug($response->result->fails);
                } else {
                    $messages = new Message;
                    foreach ($response->result->success as $success) {                        
                        $messages->contact_id     = $success->contact->id;
                        $messages->contact_name   = $success->contact->name;
                        $messages->contact_number = $success->contact->number;
                        $messages->device_id      = $success->device_id;
                        $messages->message        = $success->message;
                        $messages->type        = 'outbox';
                        $messages->expired_at        = \Carbon\Carbon::now()->timestamp($success->expires_at);
                        $messages->created_at        = \Carbon\Carbon::now();
                        $messages->updated_at        = \Carbon\Carbon::now();  
                    }                                                                       
                    if (! $messages->save() )
                      App::abort(500);  
                      Session::flash('flash_message', 'Data SMS "'.$request['name'].'" - " '.$request['message'].'" Berhasil Terkirim.');
                        }
                    } 
                    else{ 
                     // \Log::debug(json_encode($response->errors)); 
                        Session::flash('flash_message', 'SMS Pemberitahuan ke seluruh trainee "Gagal Terkirim" Periksa Kembali Koneksi internet dan pulsa pada Modem android anda');
                        return Redirect::back();
                    }           
                }
        }        
        else{
            // kirim ke 1 nomor trainee  
            abort_if(!function_exists('curl_init'), 400, 'CURL is not installed.');
            $curl = curl_init('http://smsgateway.me/api/v3/messages/send');
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, [
                'email'    => config('smsgateway.email'),
                'password' => config('smsgateway.password'),
                'device'   => config('smsgateway.device'),
                'number'   => $request->number,
                'name'     => $request->name,
                'message'  => $request->message,
            ]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            // jika sukses terkirim save ke database
            if ($response->success === true) {
                if (!empty($response->result->fails)) {
                    \Log::debug($response->result->fails);
                } else {
                    $messages = new Message;
                    foreach ($response->result->success as $success) {                        
                        $messages->contact_id     = $success->contact->id;
                        $messages->contact_name   = $success->contact->name;
                        $messages->contact_number = $success->contact->number;
                        $messages->device_id      = $success->device_id;
                        $messages->message        = $success->message;
                        $messages->type        = 'outbox';
                        $messages->expired_at        = \Carbon\Carbon::now()->timestamp($success->expires_at);
                        $messages->created_at        = \Carbon\Carbon::now();
                        $messages->updated_at        = \Carbon\Carbon::now();  
                    }                                                                       
                    if (! $messages->save() )
                      App::abort(500);  
                    Session::flash('flash_message', 'Data SMS "'.$request['name'].'" - " '.$request['message'].'" Berhasil Terkirim.');                     
                }
            } else {
                \Log::debug(json_encode($response->errors));
            }           
        }
         
        # Ubah data sms_status_tugas jadi = Sudah Dikirim
        $editTugas = Tugas::find($request->id_tugas);
        $editTugas->judul_tugas         = $editTugas->judul_tugas;
        $editTugas->deskripsi_tugas     = $editTugas->deskripsi_tugas;
        $editTugas->departemen_tugas         = $editTugas->departemen_tugas;
        $editTugas->waktu_tugas         = $editTugas->waktu_tugas;
        $editTugas->pembuat_tugas       = $editTugas->pembuat_tugas;
        $editTugas->tgl_tugas           = $editTugas->tgl_tugas;
        $editTugas->info_tugas          = $editTugas->info_tugas;
        $editTugas->status_tugas        = $editTugas->status_tugas;
        $editTugas->sms_status_tugas    = 'Sudah Dikirim';
        $editTugas->id_modul            = $editTugas->id_modul;         

        if (! $editTugas->save())
          App::abort(500);

        // return Redirect::action('Admin\MessageController@form');
        if (Auth::user()->level == 11) {
          return redirect('admin/tugas/');
        }elseif (Auth::user()->level == 12) {
          return redirect('trainer/tugas/');
        }         
    }

    public function kirimPesan(ValidationRequest $request){
        // Configure client
        $config = Configuration::getDefaultConfiguration();
        $config->setApiKey('Authorization', config('smsgateway.token'));
        $apiClient = new ApiClient($config);
        $messageClient = new MessageApi($apiClient);

        if ((string)$request['number'] == 'all') {

            $nomorTrainee = Trainee::orderBy('no_hp_trainee')->get();

            // looping sms messages
            foreach ($nomorTrainee as $no) {
                // Sending a SMS Message
                $sendMessageRequest = new SendMessageRequest([
                    'phoneNumber' => $request['number'],
                    'message' => $request['message'],
                    'deviceId' => config('smsgateway.device')
                ]);

                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest
                ]);
            }
            
            Session::flash('flash_message', 'Data SMS "'.$request['name'].'" - " '.$request['message'].'" Berhasil Terkirim.');
            return Redirect::action('Admin\MessageController@form');

        } else {
            // Sending a SMS Message
            $sendMessageRequest = new SendMessageRequest([
                'phoneNumber' => $request['number'],
                'message' => $request['message'],
                'deviceId' => config('smsgateway.device')
            ]);

            $sendMessages = $messageClient->sendMessages([
                $sendMessageRequest
            ]);

            Session::flash('flash_message', 'Data SMS "'.$request['name'].'" - " '.$request['message'].'" Berhasil Terkirim.');
            if (Auth::user()->level == 11) {
              return redirect('admin/tugas/');
            }elseif (Auth::user()->level == 12) {
              return redirect('trainer/tugas/');
            }           
        }     
    }

    public function kirimPesanEdit(ValidationRequest $request){

        // Configure client
        $config = Configuration::getDefaultConfiguration();
        $config->setApiKey('Authorization', config('smsgateway.token'));
        $apiClient = new ApiClient($config);
        $messageClient = new MessageApi($apiClient);

        if ((string)$request['number'] == 'all') {
            
            $tugas = Tugas::find($request->id_tugas);        
            $trainee_departemen = DB::table('trainees')
                    ->select('trainees.*')
                    ->where('departemen_trainee', $tugas->departemen_tugas)->get();
            // looping sms messages
            foreach ($trainee_departemen as $no) {
                // Sending a SMS Message
                $sendMessageRequest = new SendMessageRequest([
                    'phoneNumber' => $no->no_hp_trainee,
                    'message' => $request['message'],
                    'deviceId' => config('smsgateway.device')
                ]);

                $sendMessages = $messageClient->sendMessages([
                    $sendMessageRequest
                ]);
            }

             # Ubah data sms_status_tugas jadi = Sudah Dikirim
            $editTugas = Tugas::find($request->id_tugas);
            $editTugas->judul_tugas         = $editTugas->judul_tugas;
            $editTugas->deskripsi_tugas     = $editTugas->deskripsi_tugas;
            $editTugas->departemen_tugas         = $editTugas->departemen_tugas;
            $editTugas->waktu_tugas         = $editTugas->waktu_tugas;
            $editTugas->pembuat_tugas       = $editTugas->pembuat_tugas;
            $editTugas->tgl_tugas           = $editTugas->tgl_tugas;
            $editTugas->info_tugas          = $editTugas->info_tugas;
            $editTugas->status_tugas        = $editTugas->status_tugas;
            $editTugas->sms_status_tugas    = 'Sudah Dikirim';
            $editTugas->id_modul            = $editTugas->id_modul;         

            if (! $editTugas->save()){
              App::abort(500);
            }
            
            Session::flash('flash_message', 'Data SMS "'.$request['name'].'" - " '.$request['message'].'" Berhasil Terkirim.');
            if (Auth::user()->level == 11) {
              return redirect('admin/tugas/');
            }elseif (Auth::user()->level == 12) {
              return redirect('trainer/tugas/');
            } 

        } else {
            // Sending a SMS Message
            $sendMessageRequest = new SendMessageRequest([
                'phoneNumber' => $request['number'],
                'message' => $request['message'],
                'deviceId' => config('smsgateway.device')
            ]);

            $sendMessages = $messageClient->sendMessages([
                $sendMessageRequest
            ]);

            Session::flash('flash_message', 'Data SMS "'.$request['name'].'" - " '.$request['message'].'" Berhasil Terkirim.');
            if (Auth::user()->level == 11) {
              return redirect('admin/tugas/');
            }elseif (Auth::user()->level == 12) {
              return redirect('trainer/tugas/');
            }           
        }     
    }
 
    /**
     * @param ValidationRequest $request
     */
    public function send(ValidationRequest $request)    
    {        
        $nomorTrainee = Trainee::orderBy('no_hp_trainee')->get();
        // $input =$request->all(); 

        if ((string)$request['number'] == 'all') {
            // Kirim ke Semua Nomor Trainee            
            foreach ($nomorTrainee as $no) {            
            abort_if(!function_exists('curl_init'), 400, 'CURL is not installed.');
            $curl = curl_init('http://smsgateway.me/api/v3/messages/send');
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, [
                'email'    => config('smsgateway.email'),
                'password' => config('smsgateway.password'),
                'device'   => config('smsgateway.device'),
                'number'   => $no->no_hp_trainee,
                'name'     => $request->name,
                'message'  => $request->message,
            ]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            // jika sukses terkirim save ke database
            if ($response->success === true) {
                if (!empty($response->result->fails)) {
                    \Log::debug($response->result->fails);
                } else {
                    $messages = new Message;
                    foreach ($response->result->success as $success) {                        
                        $messages->contact_id     = $success->contact->id;
                        $messages->contact_name   = $success->contact->name;
                        $messages->contact_number = $success->contact->number;
                        $messages->device_id      = $success->device_id;
                        $messages->message        = $success->message;
                        $messages->type        = 'outbox';
                        $messages->expired_at        = \Carbon\Carbon::now()->timestamp($success->expires_at);
                        $messages->created_at        = \Carbon\Carbon::now();
                        $messages->updated_at        = \Carbon\Carbon::now();  
                    }                                                                       
                    if (! $messages->save() )
                      App::abort(500);  
                    Session::flash('flash_message', 'Data SMS "'.$request['name'].'" - " '.$request['message'].'" Berhasil Terkirim.');
                        }
                    } else { \Log::debug(json_encode($response->errors)); }           
                }
        }        
        else{
            // kirim ke 1 nomor trainee  
            abort_if(!function_exists('curl_init'), 400, 'CURL is not installed.');
            $curl = curl_init('http://smsgateway.me/api/v3/messages/send');
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, [
                'email'    => config('smsgateway.email'),
                'password' => config('smsgateway.password'),
                'device'   => config('smsgateway.device'),
                'number'   => $request->number,
                'name'     => $request->name,
                'message'  => $request->message,
            ]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            // jika sukses terkirim save ke database
            if ($response->success === true) {
                if (!empty($response->result->fails)) {
                    \Log::debug($response->result->fails);
                } else {
                    $messages = new Message;
                    foreach ($response->result->success as $success) {                        
                        $messages->contact_id     = $success->contact->id;
                        $messages->contact_name   = $success->contact->name;
                        $messages->contact_number = $success->contact->number;
                        $messages->device_id      = $success->device_id;
                        $messages->message        = $success->message;
                        $messages->type        = 'outbox';
                        $messages->expired_at        = \Carbon\Carbon::now()->timestamp($success->expires_at);
                        $messages->created_at        = \Carbon\Carbon::now();
                        $messages->updated_at        = \Carbon\Carbon::now();  
                    }                                                                       
                    if (! $messages->save() )
                      App::abort(500);  
                    Session::flash('flash_message', 'Data SMS "'.$request['name'].'" - " '.$request['message'].'" Berhasil Terkirim.');                     
                }
            } else {
                \Log::debug(json_encode($response->errors));
            }           
        }                
        // return Redirect::action('Admin\MessageController@form');
        if (Auth::user()->level == 11) {
          return redirect('admin/tugas/');
        }elseif (Auth::user()->level == 12) {
          return redirect('trainer/tugas/');
        }        
    }
}