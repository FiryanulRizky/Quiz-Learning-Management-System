@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Admin</li>
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
      <h3 class="box-title"> Form Tambah Data Trainee</h3>              
    </div>
    <div style="display: block;" class="box-body">
      <form id="formTraineeTambah" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ url('admin/trainee/tambah') }}" >
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-12" style="margin-left:2%;">
        <div class="col-md-6" >
        <!-- general left form elements  nisn email jk departemen id user status -->              
              <div class="form-group">
                <label class="col-sm-4  control-label" style="text-align: left;">NISN</label>
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="nisn_trainee" value="{{ old('nisn_trainee') }}" placeholder="NISN">
                    <small class="help-block"></small>
                 </div>
              </div>
              <div class="form-group">
              <label class="col-sm-4  control-label" style="text-align: left;">Nama</label>
              <div class="col-sm-8">                  
                <input type="text" class="form-control" name="nama_trainee" value="{{ old('nama_trainee') }}" placeholder="Nama">
                <small class="help-block"></small>            
              </div>      
              </div>
              <div class="form-group">
               <label class="col-sm-4  control-label" style="text-align: left;">Email</label>
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="email_trainee" value="{{ old('email_trainee') }}" placeholder="Email">
                    <small class="help-block"></small>
                 </div>
               </div>        
              <div class="form-group">
                 <label class="col-sm-4  control-label" style="text-align: left;">Jenis Kelamin</label>                   
                 <div class="col-sm-8">               
                  <select class="form-control " name="jns_kelamin_trainee" style="font-size: 14px; text-align: left;">
                   <option value="{{ old('jns_kelamin_trainee') }}">-- Pilih Jenis Kelamin --</option>
                   <option value="Laki - laki">Laki - laki</option>
                   <option value="Perempuan">Perempuan</option>                  
                  </select>
                 </div>
              </div>
              <div class="form-group" style="height: 35px">
               <label class="col-sm-4  control-label" style="text-align: left;">Tempat Tanggal Lahir</label>            
               <div class="col-sm-8">                  
                  <input type="text" class="form-control" name="ttl_trainee" value="{{ old('ttl_trainee') }}" placeholder="Tempat Tanggal Lahir">
                  <small class="help-block"></small>
               </div>
              </div>               
              <div class="form-group" >
               <label class="col-sm-4  control-label" style="text-align: left;">Nomor HP</label>
               <div class="col-sm-8">                  
                  <input type="text" class="form-control" name="no_hp_trainee" value="{{ old('no_hp_trainee') }}" placeholder="Nomor HP">
                  <small class="help-block"></small>
               </div>
              </div>                                                                                                                                                                                              
        <!-- general left form elements -->
        </div>   

        <div class="col-md-6" >
          <!-- general rigth form elements --> 
            <div class="form-group" style="height: 48px">
             <label class="col-sm-3  control-label" style="text-align: left;">Foto</label>
             <div class="col-sm-8">                  
                <input type="file" id="foto_trainee" name="foto_trainee" >
                <p class="help-block">Pilih Foto Anda. Maks Ukuran 300x300. </p>                                 
             </div>
            </div>
            <div class="form-group">
             <label class="col-sm-3  control-label" style="text-align: left;">Alamat</label>
             <div class="col-sm-8">
              <textarea class="form-control" name="alamat_trainee" placeholder="Alamat" style="height: 90px">{{ old('alamat_trainee') }}</textarea>                              
              <small class="help-block"></small>
             </div>
            </div>
            <div class="form-group">
             <label class="col-sm-3  control-label" style="text-align: left;">Departemen</label>
             <div class="col-sm-8">               
              <select class="form-control " name="departemen_trainee" style="font-size: 14px; text-align: left;">
               <option value="{{ old('departemen_trainee') }}">-- Pilih Departemen Trainee --</option>
               <option value="Manajemen"> Manajemen </option>
               <option value="Marketing"> Marketing </option>
               <option value="Operasional"> Operasional </option>
               <option value="VIII A"> VIII A </option>
               <option value="VIII B"> VIII B </option>
               <option value="VIII C"> VIII C </option>
               <option value="IX A"> IX A </option>
               <option value="IX B"> IX B </option>                   
              </select>
             </div>
            </div>
          <div class="form-group">
             <label class="col-sm-3  control-label" style="text-align: left;">Status</label>                                   
             <div class="col-sm-8">               
              <select class="form-control " name="status_trainee" style="font-size: 14px; text-align: left;">
               <option value="{{ old('status_trainee') }}">-- Pilih Status Trainee --</option>
               <option value="Aktif">Aktif</option>
               <option value="Non Aktif">Non Aktif</option>                  
              </select>
             </div>
            </div>                 
            <div class="form-group">
             <label class="col-sm-3  control-label" style="text-align: left;">ID USER</label>
             <div class="col-sm-8">               
              <select class="form-control " name="id_user" style="font-size: 14px; text-align: left;">
               <option value="{{ old('id_user') }}">-- Pilih ID User Trainee --</option>
               @foreach ($listIduser as $idUser)
                  <option value="{{ $idUser->id_user }}">id user : {{ $idUser->id_user }} | username : {{ $idUser->username }}</option>
               @endforeach                                                                                 
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
                    <a href="{{{ action('Admin\TraineeController@index') }}}" title="Cancel">
                      <span class="btn btn-default"><i class="fa fa-back"> Cancel </i></span>
                    </a>  
                 </div>
              </div>
            </div><!-- /.box-footer-->

        </form>

    </div>


            </div>
          </div><!-- /.row (main row) -->
                        
@endsection


