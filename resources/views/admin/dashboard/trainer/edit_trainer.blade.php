@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Edit Biodata diri Trainer
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          <?php if ( Auth::user()->level  == 11): ?>
            <li class="active">Admin</li>                    
          <?php endif ?>
          <?php if (Auth::user()->level  == 12): ?>
            <li class="active">Trainer</li>             
          <?php endif ?>
            <li class="active">Edit Biodata diri Trainer</li>
          </ol>
@stop
@section('content')
  <div class="row">
    <div class="col-md-12">
        <div class="uk-alert uk-alert-success" data-uk-alert>
            <a href="" class="uk-alert-close uk-close"></a>
            <p>{{  isset($successMessage) ? $successMessage : '' }}</p>
             @if (count($errors) > 0)
                <div class="alert alert-danger" align="center">
                    <strong>Maaf!</strong> Sebelum Menekan tombol "Simpan" Anda Harus Melengkapi data dibawah ini dahulu :
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
                

    <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title"> Form Edit Data Trainer</h3>              
    </div>
      
    <div style="display: block;" class="box-body">       
      <?php if ( Auth::user()->level  == 11): ?>
        <form id="formTrainerEdit" class="form-horizontal" role="form" method="POST"  files="true"  enctype="multipart/form-data" action="{{ url('admin/trainer/'.$nik_trainer.'/simpanedit') }}">
      <?php endif ?>
      <?php if (Auth::user()->level  == 12): ?>          
         <form id="formTrainerEdit" class="form-horizontal" role="form" method="POST"  files="true" enctype="multipart/form-data" action="{{ url('trainer/trainer/simpanedit') }}">         
      <?php endif ?> 
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="nik_trainer" value="{{$nik_trainer}}" >  

            <div class="col-md-12" style="margin-left:2%;"> 
            <div class="col-md-6">
            <!-- general left form elements  nisn email jk departemen id user status --> 
            <div class="form-group">
                <label class="col-sm-4 control-label" style="text-align: left;">NIK</label>
                 <div class="col-sm-8">                                      
                    <?php if ( Auth::user()->level  == 11): ?>
                      <input type="text" class="form-control" name="nik_trainer" value="{{ $nik_trainer }}">
                    <?php endif ?>
                    <?php if (Auth::user()->level  == 12): ?>
                      <input type="text" class="form-control" name="nik_trainer" value="{{ $nik_trainer }}" readonly="true">
                    <?php endif ?>
                    <small class="help-block"></small>
                 </div>
               </div>

              <div class="form-group">
                <label class="col-sm-4 control-label" style="text-align: left;">Nama</label>
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="nama_trainer" value="{{ $nama_trainer }}" >
                    <small class="help-block"></small>            
                </div>  
              </div>

              <div class="form-group" style="height: 42px">
                 <label class="col-sm-4 control-label" style="text-align: left;">Tempat Tanggal Lahir </label>            
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="ttl_trainer" value="{{ $ttl_trainer }}" >
                    <small class="help-block"></small>
                 </div>
              </div> 

              <div class="form-group" style="height: 46px">
                 <label class="col-sm-4 control-label" style="text-align: left;">Jenis Kelamin</label>                   
                 <div class="col-sm-8">               
                  <select class="form-control " name="jns_kelamin_trainer" style="font-size: 14px; text-align: left;">
                   <option value="{{ $jns_kelamin_trainer }}">-- {{ $jns_kelamin_trainer }} --</option>
                   <option value="Laki - laki">Laki - laki</option>
                   <option value="Perempuan">Perempuan</option>                  
                  </select>
                 </div>
              </div> 

              <div class="form-group">
                  <label class="col-sm-4 control-label" style="text-align: left;">Agama</label>
                    <div class="col-sm-8">                               
                      <select class="form-control " name="agama_trainer" style="font-size: 14px; text-align: left;">
                        <option value="{{ $agama_trainer }}">-- {{ $agama_trainer }} --</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Khatolik">Khatolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Budha">Budha</option>
                        <option value="Lainnya">Lainnya</option>
                      </select>  
                    </div>
              </div>

               <div class="form-group">
                <label class="col-sm-4 control-label" style="text-align: left;">Nomor HP</label>
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="no_telp_trainer" value="{{ $no_telp_trainer }}">
                    <small class="help-block"></small>
                 </div>
               </div>

                <div class="form-group">
               <label class="col-sm-4 control-label" style="text-align: left;">Email</label>
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="email_trainer" value="{{ $email_trainer }}">
                    <small class="help-block"></small>
                 </div>
               </div>
          </div>

          <div class="col-md-6">
            <!-- general right form elements  nisn email jk departemen id user status --> 
            <div class="form-group">
                 <label class="col-sm-3 control-label" style="text-align: left;">Alamat</label>
                 <div class="col-sm-8">
                  <textarea class="form-control" name="alamat_trainer" value="{{ $alamat_trainer }}" style="height: 90px">{{ $alamat_trainer }}</textarea>                              
                  <small class="help-block"></small>
                 </div>
               </div>                 

               <div class="form-group">
                 <label class="col-sm-3 control-label" style="text-align: left;">Jabatan</label>
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="jabatan_trainer" value="{{ $jabatan_trainer }}">
                    <small class="help-block"></small>
                 </div>
                </div>
                
                <div class="form-group" style="height: 48px">
                 <label class="col-sm-3  control-label" style="text-align: left;">Foto</label>
                 <div class="col-sm-8">                  
                    <input type="file" id="foto_trainer" name="foto_trainer" value="{{ $foto_trainer }}">
                    <p class="help-block">-- {{$foto_trainer}} -- </p>                                 
                 </div>
                </div>
 
 

                <div class="form-group">
                 <label class="col-sm-3 control-label" style="text-align: left;">Status</label>                                   
                 <div class="col-sm-8">               
                  <select class="form-control " name="status_trainer" style="font-size: 14px; text-align: left;">
                   <?php if ( Auth::user()->level  == 11): ?>
                    <option value="{{ $status_trainer }}">-- {{ $status_trainer }} --</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Non Aktif">Non Aktif</option> 
                   <?php endif ?>
                   <?php if (Auth::user()->level  == 12): ?>
                    <option value="{{ $status_trainer }}">-- {{ $status_trainer }} --</option>
                   <?php endif ?>             
                  </select>
                 </div>
                </div>                 

                <div class="form-group">
                 <label class="col-sm-3 control-label" style="text-align: left;">ID USER</label>
                 <div class="col-sm-8">               
                  <select class="form-control " name="id_user" style="font-size: 14px; text-align: left;">                  
                   <?php if ( Auth::user()->level  == 11): ?>
                    <option value="{{ $id_user }}">-- id user : {{ $id_user }} | username : {{ $nik_trainer }} --</option>                  
                    @foreach ($userData as $idUser)
                      <option value="{{ $idUser->id_user }}">id user : {{ $idUser->id_user }} | username : {{ $idUser->username }}</option>
                    @endforeach 
                   <?php endif ?>
                   <?php if (Auth::user()->level  == 12): ?>
                      <option value="{{ $id_user }}">-- id user : {{ $id_user }} | username : {{ $nik_trainer }} --</option>
                   <?php endif ?>                                                                                
                  </select>
                 </div>   
                </div> 
            </div>                                                   
          </div>
       
              </div><!-- /.box-body -->
            <div style="display: block;" class="box-footer" >
              <div class="form-group"> 
                 <div class="col-md-8 col-md-offset-5">
                   <button type="submit" class="btn btn-primary" id="button-reg">
                      Simpan
                   </button>                    
                    <?php if ( Auth::user()->level  == 11): ?> 
                    <a href="{{{ action('Admin\TrainerController@index') }}}" title="Cancel">
                      <span class="btn btn-default"><i class="fa fa-back"> Cancel </i></span>
                    </a> 
                    <?php endif ?> 
                    <?php if ( Auth::user()->level  == 12): ?> 
                    <a href="{{{ URL::to('trainer/trainer/'.$nik_trainer.'/detail') }}}" title="Cancel">
                      <span class="btn btn-default"><i class="fa fa-back"> Cancel </i></span>
                    </a>
                   <?php endif ?> 
                 </div>
              </div>
            </div><!-- /.box-footer-->
        </form>
  </div>

  </div>
</div><!-- /.row (main row) -->
                        
@endsection


