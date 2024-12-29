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
              <h3 class="box-title"> Form Edit Data Nilai</h3>              
           </div>

        <div style="display: block; " class="box-body">                         
                       <form id="formNilaiEdit" class="form-horizontal" role="form" method="POST" action="{{ url('admin/nilai/'.$id_nilai_trainee.'/simpanedit') }}">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="PUT">
                      <input type="hidden" name="id_nilai_trainee" value="{{$id_nilai_trainee}}" >                                                

                      <div class="form-group">
                       <label class="col-md-3 control-label">NIK Trainee</label>
                       <div class="col-md-8">               
                        <select class="form-control " name="nik_trainee" style="font-size: 14px; text-align: left;">
                         <option value="{{ $nik_trainee }}">-- {{ $nik_trainee }} --</option>
                         @foreach ($Trainee as $idTrainee)
                            <option value="{{ $idTrainee->nik_trainee }}">nisn trainee : {{ $idTrainee->nik_trainee }} | nama : {{ $idTrainee->nama_trainee }}</option>
                         @endforeach                                                                                 
                        </select>
                       </div>   
                      </div>

                      <div class="form-group">
                       <label class="col-md-3 control-label">ID Nilai Tugas</label>
                       <div class="col-md-8">               
                        <select class="form-control " name="nilai_tugas_trainees" style="font-size: 14px; text-align: left;">
                         <option value="{{ $id_nilai_tugas_trainee }}">-- {{ $id_nilai_tugas_trainee }} --</option>
                         @foreach ($NilaiTugas as $idNilaiTugas)
                            <option value="{{ $idNilaiTugas->id_nilai_tugas_trainee }}">nisn trainee : {{ $idNilaiTugas->id_nilai_tugas_trainee }} | nisn trainee : {{ $idNilaiTugas->nik_trainee }}</option>
                         @endforeach                                                                                 
                        </select>
                       </div>   
                      </div>

                      <div class="form-group">
                       <label class="col-md-3 control-label">ID Nilai Quiz</label>
                       <div class="col-md-8">               
                        <select class="form-control " name="nilai_quiz_trainees" style="font-size: 14px; text-align: left;">
                         <option value="{{ $idNilaiQuiz->id_nilai_quiz_trainee }}">-- {{ $id_nilai_quiz_trainee }}n --</option>
                         @foreach ($NilaiQuiz as $idNilaiQuiz)
                            <option value="{{ $id_nilai_quiz_trainee }}">nisn trainee : {{ $idNilaiQuiz->id_nilai_quiz_trainee }} | nisn trainee : {{ $idNilaiQuiz->nik_trainee }}</option>
                         @endforeach                                                                                 
                        </select>
                       </div>   
                      </div>
                      
                   </div><!-- /.box-body -->
                      <div style="display: block;" class="box-footer" >
                        <div class="form-group"> 
                           <div class="col-md-8 col-md-offset-5">
                             <button type="submit" class="btn btn-primary" id="button-reg" style="font-size: 14px; text-align: left;">
                                Simpan
                             </button>
                              <a href="{{{ action('Admin\NilaiController@index') }}}" title="Cancel">
                                <span class="btn btn-default"><i class="fa fa-back"> Cancel </i></span>
                              </a>  
                           </div>
                        </div>
                      </div><!-- /.box-footer-->
                    </form>   
                  </div>
                </div><!-- /.box -->
          </div><!-- /.row (main row) -->
                        
@endsection


