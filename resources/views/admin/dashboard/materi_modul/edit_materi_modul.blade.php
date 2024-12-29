@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Edit Data Modul Menu
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
            <li class="active">Edit Data Modul Menu</li>
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
                  <div class="box-header">
                    <h3 class="box-title">Form Edit Data Modul Menu</h3>
                </div><!-- /.box-header -->
                  <div class="box-body no-padding">                      
                      <?php if ( Auth::user()->level  == 11): ?>
                        <form id="formMateriModulEdit" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ url('admin/materi_modul/'.$id_materi_modul.'/simpanedit') }}" >
                      <?php endif ?>

                      <?php if (Auth::user()->level  == 12): ?>                        
                        <form id="formMateriModulEdit" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ url('trainer/materi_modul/'.$id_materi_modul.'/simpanedit') }}" >
                      <?php endif ?> 
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="PUT">
                      <input type="hidden" name="id_materi_modul" value="{{$id_materi_modul}}" > 
                                        
                      <div class="col-md-11" style="margin-left:8%;">
                      <div class="form-group">
                          <label class="col-sm-3 control-label" style="text-align: left;"> Judul </label>
                          <div class="col-sm-8"">
                              <input type="text" class="form-control" name="materi_judul" value="{{ $materi_judul }}">
                              <small class="help-block"></small>
                          </div>
                      </div>                      

                    <div class="form-group" style="height: 48px">
                     <label class="col-sm-3  control-label" style="text-align: left;">Nama Materi</label>
                     <div class="col-sm-8">                  
                        <input type="file" id="materi_nama" name="materi_nama" src="{{URL::to('upload_file/'.$materi_nama) }}">
                        <p class="help-block">{{ $materi_nama }} </p>                                 
                     </div>
                    </div>

                      <div class="form-group">
                          <label class="col-sm-3 control-label" style="text-align: left;"> ID Materi Modul </label>
                           <div class="col-sm-8"">               
                            <select class="form-control" name="id_modul" style="font-size: 14px; text-align: left;">
                             <?php if ( Auth::user()->level  == 11): ?>
                               <option value="{{ $id_modul }}">-- id modul : {{ $id_modul }}  --</option>
                                @foreach ($dataModul_learn as $Modul_learn)
                                <option value="{{ $Modul_learn->id_modul }}">id modul : {{ $Modul_learn->id_modul }} | nama modul : {{ $Modul_learn->nama_modul }}</option>
                                @endforeach 
                            <?php endif ?>

                            <?php if (Auth::user()->level  == 12): ?>
                              <option value="{{ $dataModul_learn->id_modul }}">-- id modul : {{ $dataModul_learn->id_modul }} | nama modul : {{ $dataModul_learn->nama_modul }} --</option>
                            <?php endif ?>

                            </select>
                           </div>        
                      </div> 

                      <div class="form-group">
                       <label class="col-sm-3 control-label" style="text-align: left;">Departemen</label>
                       <div class="col-sm-8">               
                        <select class="form-control" name="materi_departemen" style="font-size: 14px; text-align: left;">                         
                         <?php if ( Auth::user()->level  == 11): ?>
                           <option value="{{ $materi_departemen }}">-- {{ $materi_departemen }} --</option>
                           <option value="Manajemen"> Manajemen </option>
                           <option value="Marketing"> Marketing </option>
                           <option value="Operasional"> Operasional </option>
                           <option value="Billing"> Billing </option>
                           <option value="Account Payable"> Account Payable </option>
                           <option value="Account Receivable"> Account Receivable </option>
                           <option value="Warehouse Inventory"> Warehouse Inventory </option>
                           <option value="Fleet Yard"> Fleet Yard </option> 
                        <?php endif ?>

                        <?php if (Auth::user()->level  == 12): ?>
                          <option value="{{ $materi_departemen }}">-- {{ $materi_departemen }} --</option>
                          @foreach ($dataDepartemen as $Departemen)
                           <option value="{{ $Departemen->nama_departemen }}"> {{ $Departemen->nama_departemen }} </option>
                          @endforeach 
                        <?php endif ?>                  
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

                              <?php if ( Auth::user()->level  == 11): ?>
                                <a href="{{{ url('admin/materi_modul') }}}" title="Cancel">
                                <span class="btn btn-default"><i class="fa fa-back"> Cancel </i></span>
                                </a> 
                              <?php endif ?>

                              <?php if (Auth::user()->level  == 12): ?>
                                <a href="{{{ url('trainer/materi_modul') }}}" title="Cancel">
                                <span class="btn btn-default"><i class="fa fa-back"> Cancel </i></span>
                                </a> 
                              <?php endif ?>   
                          </div>
                      </div>
                      </div><!-- /.box-footer-->
                      </form>   
                </div><!-- /.box -->
            </div>
          </div><!-- /.row (main row) -->
                        
@endsection


