@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Dashboard Trainer
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard Trainer</li>
          </ol>
@stop
@section('content')

    <div class="callout callout-danger" style="text-align: center; color: black;">
        <h3> <b>E-LEARNING SOFTWARE LOGISTICS PT. TRANS CONTINENT</b></h3>
        <h4 >Selamat Datang Trainer!</h4>        
    </div>              

    <div class="row"> 
    <br><br><br><br><br><br>     
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue"> 
          <div class="inner">
            <h3>{{$countMateriModul}}</h3>
            <p>Modul Menu</p>
          </div>
          <div class="icon">
            <i class="fa fa-list-ol"></i>
          </div>
          <a href="{{url('trainer/materi_modul')}}" class="small-box-footer" data-toggle="tooltip" data-title="Kelola Modul Menu">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3>{{$countTugas}}</h3>
            <p>Tugas</p>
          </div>
          <div class="icon">
            <i class="fa fa-tasks"></i>
          </div>
          <a href="{{url('trainer/tugas')}}" class="small-box-footer" data-toggle="tooltip" data-title="Kelola Tugas">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
          <div class="inner">
            <h3>{{$countSoal}}</h3>
            <p>Soal Quiz</p>
          </div>
          <div class="icon">
            <i class="fa fa-file-text-o"></i>
          </div>
          <a href="{{url('trainer/soal_quiz')}}" class="small-box-footer" data-toggle="tooltip" data-title="Kelola Soal Quiz">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
          <div class="inner">
            <h3>{{$countQuiz}}</h3>
            <p>Quiz</p>
          </div>
          <div class="icon">
            <i class="fa fa-edit "></i>
          </div>
          <a href="{{url('trainer/quiz')}}" class="small-box-footer" data-toggle="tooltip" data-title="Kelola Quiz">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
  </div>
             
@endsection
@section('script')



@endsection
