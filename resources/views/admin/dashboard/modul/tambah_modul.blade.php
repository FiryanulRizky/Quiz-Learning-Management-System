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
      <h3 class="box-title"> Form Tambah Data Modul</h3>              
    </div>
    <div style="display: block;" class="box-body">
      <form id="formModul_learnTambah" class="form-horizontal" role="form" method="POST" action="{{ url('admin/modul_learn/tambah') }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-11" style="margin-left:8%;">
                <div class="form-group">
                    <label class="col-md-2 control-label" style="text-align: left;"> Nama Modul_learn</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="nama_modul" value="" placeholder="Nama Modul">
                        <small class="help-block"></small>
                    </div>
                </div>

                <div class="form-group">
                 <label class="col-md-2 control-label" style="text-align: left;">NIK Trainer</label>
                 <div class="col-md-9">               
                  <select class="form-control " name="nik_trainer" style="font-size: 14px; text-align: left;">
                   <option value="">-- Pilih NIK Trainer --</option>
                   @foreach ($Trainer as $idTrainer)
                      <option value="{{ $idTrainer->nik_trainer }}">nik trainer : {{ $idTrainer->nik_trainer }} | nama trainer: {{ $idTrainer->nama_trainer }}</option>
                   @endforeach                                                                                 
                  </select>
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
                    <a href="{{{ action('Admin\ModulController@index') }}}" title="Cancel">
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


