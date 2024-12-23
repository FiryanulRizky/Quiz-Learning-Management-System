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
        <h3 class="box-title">Form Edit Data Ujian </h3>
    </div>

      <div style="display: block;" class="box-body"> <!-- box-body -->    
        @if(Auth::user()->level  == 11)                  
          <form id="formUjianEdit" class="form-horizontal" role="form" method="POST" action="{{ url('admin/ujian/'.$id_ujian.'/simpanedit') }}">
        @elseif(Auth::user()->level  == 12)
          <form id="formUjianEdit" class="form-horizontal" role="form" method="POST" action="{{ url('trainer/ujian/'.$id_ujian.'/simpanedit') }}">
        @endif
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="id_ujian" value="{{$id_ujian}}" >                                                
          
          <div class="col-md-12" style="margin-left:0%;">
            <div class="col-md-6"> 
              <!-- general left form elements  --> 
               <div class="form-group">
                 <label class="col-sm-4 control-label" style="text-align: left;">Jenis Ujian</label>                                   
                 <div class="col-sm-8">               
                  <select class="form-control " name="jenis_ujian" style="font-size: 14px; text-align: left;">
                   <option value="{{$jenis_ujian}}">-- {{$jenis_ujian}} --</option>
                   <option value="Ujian Harian">Ujian Harian</option>
                   <option value="Ujian Mid">Ujian Mid</option>                  
                  </select>
                 </div>
                </div>

                <div class="form-group">
                 <label class="col-sm-4 control-label" style="text-align: left;">Departemen</label>
                 <div class="col-sm-8">               
                  <select class="form-control " name="departemen_ujian" style="font-size: 14px; text-align: left;">
                   <option value="{{$departemen_ujian}}">-- {{$departemen_ujian}} --</option>
                   <option value="Manajemen"> Manajemen </option>
                   <option value="Marketing"> Marketing </option>
                   <option value="Operasional"> Operasional </option>
                   <option value="Billing"> Billing </option>
                   <option value="Account Payable"> Account Payable </option>
                   <option value="Account Receivable"> Account Receivable </option>
                   <option value="Warehouse Inventory"> Warehouse Inventory </option>
                   <option value="Fleet Yard"> Fleet Yard </option>                   
                  </select>
                 </div>
                </div>

                <div class="form-group">
                 <label class="col-sm-4 control-label" style="text-align: left;">ID Modul_learn</label>
                 <div class="col-sm-8">               
                  <select class="form-control " name="id_modul" style="font-size: 14px; text-align: left;">
                   <option value="{{$id_modul}}">-- {{$id_modul}} --</option>
                   @if(Auth::user()->level  == 11)
                   @foreach ($Modul_learn as $idModul_learn)
                      <option value="{{$idModul_learn->id_modul}}">id modul : {{ $idModul_learn->id_modul }} | nama : {{ $idModul_learn->nama_modul }}</option>
                   @endforeach                   
                   @elseif(Auth::user()->level  == 12)
                      <option value="{{$dataModul_learn->id_modul}}">id modul : {{ $dataModul_learn->id_modul }} | nama : {{ $dataModul_learn->nama_modul }}</option>
                    @endif                                                     
                  </select>
                 </div>   
                </div>

                <div class="form-group">
                <label class="col-sm-4 control-label" style="text-align: left;">Tanggal  </label>  
                <div class="col-sm-8">
                 <input type="text" class="form-control datepicker" name="tgl_ujian" style="height: 33px" value="{{$tgl_ujian}}">
                </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-4 control-label" style="text-align: left;">Pembuat </label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="pembuat_ujian" value="{{$pembuat_ujian}}" readonly="true">
                      <small class="help-block"></small>
                  </div>
              </div> 

              <div class="form-group" style="height: 35px">
                <label class="col-sm-4 control-label" style="text-align: left;">Nama </label> 
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="judul_ujian" value="{{$judul_ujian}}" placeholder="Nama Ujian">
                    <small class="help-block"></small>
                 </div>
               </div> 
              <!-- general left form elements  -->
            </div>
            <div class="col-md-6"> 
              <!-- general right form elements -->
              <div class="form-group" >
                 <label class="col-sm-4 control-label" style="text-align: left;">Acak Soal</label>                   
                 <div class="col-sm-8">               
                  <select class="form-control " name="is_random" style="font-size: 14px; text-align: left;">
                   <option value="{{$is_random}}">-- {{$is_random ? 'Ya': 'Tidak'}} --</option>
                   <option value="1">Ya</option>
                   <option value="0">Tidak</option>                 
                  </select>
                 </div>
              </div> 
              
               <div class="form-group" style="height: 35px">
               <label class="col-sm-4 control-label" style="text-align: left;">Waktu ( Menit )</label>
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="waktu_ujian" value="{{$waktu_ujian}}">
                    <small class="help-block"></small>
                 </div>
               </div>
              
              <div class="form-group" style="height: 30px">
                 <label class="col-sm-4 control-label" style="text-align: left;">Info</label>
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="info_ujian" value="{{$info_ujian}}" style="height: 35px">
                    <small class="help-block"></small>
                 </div>
              </div>
              
              <div class="form-group" >
                 <label class="col-sm-4 control-label" style="text-align: left;">Status Ujian</label>                   
                 <div class="col-sm-8">               
                  <select class="form-control " name="status_ujian" style="font-size: 14px; text-align: left; height: 40px">
                   <option value="{{$status_ujian}}">-- {{$status_ujian}} --</option>
                   <option value="Aktif">Aktif</option>
                   <option value="Non Aktif">Non Aktif</option>                 
                  </select>
                 </div>
              </div>

              <div class="form-group" style="height: 30px">
                 <label class="col-sm-4 control-label" style="text-align: left;">Jumlah Soal</label>
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="jumlah_soal" value="{{$jumlah_soal}}" style="height: 35px">
                    <small class="help-block"></small>
                 </div>
              </div>
              <!-- general right form elements -->
            </div>
          </div>
                                           
          </div><!-- /.box-body -->
            <div style="display: block;" class="box-footer" >
              <div class="form-group"> 
                 <div class="col-md-8 col-md-offset-5">
                   <button type="submit" class="btn btn-primary" id="button-reg">
                      Simpan
                   </button>
                    <a href="{{{ action('Admin\UjianController@index') }}}" title="Cancel">
                      <span class="btn btn-default"><i class="fa fa-back"> Cancel </i></span>
                    </a>  
                 </div>
              </div>
            </div><!-- /.box-footer-->
          </form>
        </div><!-- /.box-body -->         
      </div><!-- /.box -->            
    </div><!-- /.row (main row) -->
                        
@endsection

@section('script')

<script src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('admin/plugins/select2/select2.js') }}"></script>
<script src="{{ URL::asset('admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

<script>
   $(document).ready(function() {   
     $('.datepicker').datepicker({
                  todayBtn: "linked",
                  orientation: "left",
                  format: 'yyyy-mm-dd'
        });
    }); 
    
</script>
    
@endsection

