@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Edit Biodata diri trainee
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>          
          <?php if ( Auth::user()->level  == 11): ?>
            <li class="active">Admin</li>                    
          <?php endif ?>
          <?php if (Auth::user()->level  == 13): ?>
            <li class="active">Trainee</li>             
          <?php endif ?>
            <li class="active">Edit Biodata diri trainee</li> 
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
      <h3 class="box-title">Form Edit Data Trainee</h3>              
    </div>
    
    <div style="display: block;" class="box-body">
    <?php if ( Auth::user()->level  == 11): ?>
      <form id="formTraineeEdit" class="form-horizontal" role="form" method="POST" files="true" enctype="multipart/form-data" action="{{ url('admin/trainee/'.$nik_trainee.'/simpanedit') }}" >                    
    <?php endif ?>
    <?php if (Auth::user()->level  == 13): ?>
       <form id="formTraineeEdit" class="form-horizontal" role="form" method="POST" files="true" enctype="multipart/form-data" action="{{ url('trainee/trainee/simpanedit') }}" >           
    <?php endif ?>      
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="nik_trainee" value="{{$nik_trainee}}" >
          <div class="col-md-12" style="margin-left:2%;">
            <div class="col-md-6">
        <!-- general left form elements  nisn email jk departemen id user status -->              
              <div class="form-group">
                <label class="col-sm-4  control-label" style="text-align: left;">NISN</label>
                 <div class="col-sm-8"> 
                    <?php if ( Auth::user()->level  == 11): ?>
                      <input type="text" class="form-control" name="nik_trainee" value="{{$nik_trainee}}">
                    <?php endif ?>
                    <?php if (Auth::user()->level  == 13): ?>
                      <input type="text" class="form-control" name="nik_trainee" value="{{$nik_trainee}}" readonly="true">
                    <?php endif ?>                                      
                    <small class="help-block"></small>
                 </div>
              </div>
              <div class="form-group">
              <label class="col-sm-4  control-label" style="text-align: left;">Nama</label>
              <div class="col-sm-8">                  
                <input type="text" class="form-control" name="nama_trainee" value="{{$nama_trainee}}">
                <small class="help-block"></small>            
              </div>      
              </div>
              <div class="form-group">
               <label class="col-sm-4  control-label" style="text-align: left;">Email</label>
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="email_trainee" value="{{$email_trainee}}">
                    <small class="help-block"></small>
                 </div>
               </div>        
              <div class="form-group">
                 <label class="col-sm-4  control-label" style="text-align: left;">Jenis Kelamin</label>                   
                 <div class="col-sm-8">               
                  <select class="form-control " name="jns_kelamin_trainee" style="font-size: 14px; text-align: left;">
                   <option value="{{$jns_kelamin_trainee}}">-- {{$jns_kelamin_trainee}} --</option>
                   <option value="Laki - laki">Laki - laki</option>
                   <option value="Perempuan">Perempuan</option>                  
                  </select>
                 </div>
              </div>
              <div class="form-group" style="height: 35px">
               <label class="col-sm-4  control-label" style="text-align: left;">Tempat Tanggal Lahir</label>            
               <div class="col-sm-8">                  
                  <input type="text" class="form-control" name="ttl_trainee" value="{{$ttl_trainee}}">
                  <small class="help-block"></small>
               </div>
              </div>               
              <div class="form-group" >
               <label class="col-sm-4  control-label" style="text-align: left;">Nomor HP</label>
               <div class="col-sm-8">                  
                  <input type="text" class="form-control" name="no_hp_trainee" value="{{$no_hp_trainee}}">
                  <small class="help-block"></small>
               </div>
              </div>                                                                                                                                                                                              
        <!-- general left form elements -->
        </div>   

        <div class="col-md-6">
          <!-- general rigth form elements --> 
            <div class="form-group" style="height: 48px">
             <label class="col-sm-3  control-label" style="text-align: left;">Foto</label>
             <div class="col-sm-8">                  
                <input type="file" id="foto_trainee" name="foto_trainee" value="{!! old('foto_trainee', $foto_trainee) !!}">
                <p class="help-block">-- {!! old('foto_trainee', $foto_trainee) !!} --</p>                                 
             </div>
            </div>
            <div class="form-group">
             <label class="col-sm-3  control-label" style="text-align: left;">Alamat</label>
             <div class="col-sm-8">
              <textarea class="form-control" name="alamat_trainee" value="{{$alamat_trainee}}" style="height: 90px">{{$alamat_trainee}}</textarea>                              
              <small class="help-block"></small>
             </div>
            </div>
            <div class="form-group">
             <label class="col-sm-3  control-label" style="text-align: left;">Departemen</label>
             <div class="col-sm-8">               
              <select class="form-control " name="departemen_trainee" style="font-size: 14px; text-align: left;">               
              <?php if ( Auth::user()->level  == 11): ?>
               <option value="{{$departemen_trainee}}">-- {{$departemen_trainee}} --</option>
               <option value="Manajemen"> Manajemen </option>
               <option value="Marketing"> Marketing </option>
               <option value="Operasional"> Operasional </option>
               <option value="Billing"> Billing </option>
               <option value="Account Payable"> Account Payable </option>
               <option value="Account Receivable"> Account Receivable </option>
               <option value="Warehouse Inventory"> Warehouse Inventory </option>
               <option value="Fleet Yard"> Fleet Yard </option> 
              <?php endif ?>
              <?php if (Auth::user()->level  == 13): ?>
                <option value="{{$departemen_trainee}}">-- {{$departemen_trainee}} --</option>
              <?php endif ?>                   
              </select>
             </div>
            </div>
          <div class="form-group">
             <label class="col-sm-3  control-label" style="text-align: left;">Status</label>                                   
             <div class="col-sm-8">               
              <select class="form-control " name="status_trainee" style="font-size: 14px; text-align: left;">               
              <?php if ( Auth::user()->level  == 11): ?>
                <option value="{{$status_trainee}}">-- {{$status_trainee}} --</option>
                <option value="Aktif">Aktif</option>
                <option value="Non Aktif">Non Aktif</option>
              <?php endif ?>
              <?php if (Auth::user()->level  == 13): ?>
                <option value="{{$status_trainee}}">-- {{$status_trainee}} --</option>
              <?php endif ?>                                
              </select>
             </div>
            </div>                 
            <div class="form-group">
             <label class="col-sm-3  control-label" style="text-align: left;">ID USER</label>
             <div class="col-sm-8">               
              <select class="form-control " name="id_user" style="font-size: 14px; text-align: left;">               
              <?php if ( Auth::user()->level  == 11): ?>
                <option value="{{$id_user}}">-- id user : {{ $id_user }} | username : {{ $nik_trainee }} --</option>
                @foreach ($userData as $User)
                  <option value="{{ $User->id_user }}">id user : {{ $User->id_user }} | username : {{ $User->username }}</option>
                @endforeach 
              <?php endif ?>
              <?php if (Auth::user()->level  == 13): ?>
                <option value="{{$id_user}}">-- id user : {{ $id_user }} | username : {{ $nik_trainee }} --</option>
              <?php endif ?> 
              </select>
             </div>   
            </div>
          <!-- general rigth form elements -->
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
                    <a href="{{{ action('Admin\TraineeController@index') }}}" title="Cancel">
                      <span class="btn btn-default"><i class="fa fa-back"> Cancel </i></span>
                    </a> 
                    <?php endif ?> 
                    <?php if ( Auth::user()->level  == 13): ?> 
                    <a href="{{{ URL::to('trainee/trainee/'.$nik_trainee.'/detail') }}}" title="Cancel">
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