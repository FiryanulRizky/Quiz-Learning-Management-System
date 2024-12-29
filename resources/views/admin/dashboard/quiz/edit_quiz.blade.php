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
        <h3 class="box-title">Form Edit Data Quiz </h3>
    </div>

      <div style="display: block;" class="box-body"> <!-- box-body -->    
        @if(Auth::user()->level  == 11)                  
          <form id="formQuizEdit" class="form-horizontal" role="form" method="POST" action="{{ url('admin/quiz/'.$id_quiz.'/simpanedit') }}">
        @elseif(Auth::user()->level  == 12)
          <form id="formQuizEdit" class="form-horizontal" role="form" method="POST" action="{{ url('trainer/quiz/'.$id_quiz.'/simpanedit') }}">
        @endif
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="id_quiz" value="{{$id_quiz}}" >                                                
          
          <div class="col-md-12" style="margin-left:0%;">
            <div class="col-md-6"> 
              <!-- general left form elements  --> 
               <div class="form-group">
                 <label class="col-sm-4 control-label" style="text-align: left;">Jenis Quiz</label>                                   
                 <div class="col-sm-8">               
                  <select class="form-control " name="jenis_quiz" style="font-size: 14px; text-align: left;">
                   <option value="{{$jenis_quiz}}">-- {{$jenis_quiz}} --</option>
                   <option value="Quiz Latihan">Quiz Latihan</option>
                   <option value="Quiz Uji Kompetensi">Quiz Uji Kompetensi</option>                  
                  </select>
                 </div>
                </div>

                <div class="form-group">
                 <label class="col-sm-4 control-label" style="text-align: left;">Departemen</label>
                 <div class="col-sm-8">               
                  <select class="form-control " name="departemen_quiz" style="font-size: 14px; text-align: left;">
                   <option value="{{$departemen_quiz}}">-- {{$departemen_quiz}} --</option>
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
                 <input type="text" class="form-control datepicker" name="tgl_quiz" style="height: 33px" value="{{$tgl_quiz}}">
                </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-4 control-label" style="text-align: left;">Pembuat </label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="pembuat_quiz" value="{{$pembuat_quiz}}" readonly="true">
                      <small class="help-block"></small>
                  </div>
              </div> 

              <div class="form-group" style="height: 35px">
                <label class="col-sm-4 control-label" style="text-align: left;">Nama </label> 
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="judul_quiz" value="{{$judul_quiz}}" placeholder="Nama Quiz">
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
                    <input type="text" class="form-control" name="waktu_quiz" value="{{$waktu_quiz}}">
                    <small class="help-block"></small>
                 </div>
               </div>
              
              <div class="form-group" style="height: 30px">
                 <label class="col-sm-4 control-label" style="text-align: left;">Info</label>
                 <div class="col-sm-8">                  
                    <input type="text" class="form-control" name="info_quiz" value="{{$info_quiz}}" style="height: 35px">
                    <small class="help-block"></small>
                 </div>
              </div>
              
              <div class="form-group" >
                 <label class="col-sm-4 control-label" style="text-align: left;">Status Quiz</label>                   
                 <div class="col-sm-8">               
                  <select class="form-control " name="status_quiz" style="font-size: 14px; text-align: left; height: 40px">
                   <option value="{{$status_quiz}}">-- {{$status_quiz}} --</option>
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
                    <a href="{{{ action('Admin\QuizController@index') }}}" title="Cancel">
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

