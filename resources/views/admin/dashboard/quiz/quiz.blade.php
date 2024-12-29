@extends('admin.layout.master')
@section('breadcrump')
          <?php if ( Auth::user()->level  == 11 or  Auth::user()->level  == 12): ?>
            <h1> Data Quiz
          <?php endif ?>
          <?php if ( Auth::user()->level  == 13): ?>
            <h1>Quiz Online departemen "{{ $trainee->departemen_trainee }}"
          <?php endif ?>
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>            
          <?php if ( Auth::user()->level  == 11): ?>
            <li class="active">Admin</li> 
            <li class="active">Data Quiz</li>        
          <?php endif ?>

          <?php if (Auth::user()->level  == 12): ?>
            <li class="active">Trainer</li> 
            <li class="active">Data Quiz</li> 
          <?php endif ?>  

          <?php if (Auth::user()->level  == 13): ?>
            <li class="active">Trainee</li> 
            <li class="active">Quiz Online departemen "{{ $trainee->departemen_trainee }}"</li> 
          <?php endif ?>           
          </ol>
@stop

@section('content')

          <div class="row">
            <div class="col-xs-12">
              <?php if ( Auth::user()->level  == 11 or  Auth::user()->level  == 12): ?>
              <div class="box box-danger">                
                  <div class="box-header with-border">
                    
                    <?php if ( Auth::user()->level  == 11): ?>
                      <h3 class="box-title">Tambah Quiz <a href="{{{ URL::to('admin/tambahquiz') }}}" class="btn btn-success btn-flat btn-sm" id="tambahQuiz" title="Tambah"><i class="fa fa-plus"></i></a></h3>
                    <?php endif ?>
                    <?php if (Auth::user()->level  == 12): ?>
                      <h3 class="box-title">Tambah Quiz <a href="{{{ URL::to('trainer/tambahquiz') }}}" class="btn btn-success btn-flat btn-sm" id="tambahQuiz" title="Tambah"><i class="fa fa-plus"></i></a></h3>
                    <?php endif ?>
                  </div><!-- /.box-header -->                  

                <div class="box-body">
                  <table id="dataTabelQuiz" class="table table-bordered table-hover">
                    <thead>
                      <tr>      
                        <th>No</th>  
                        <th>Jenis </th>                          
                        <th>Nama</th>  
                        <th>Keterangan</th>
                        <th>Modul</th>          
                        <th>Departemen</th>
                        <th>Waktu</th>
                        <th>Jumlah Soal</th>
                        <th>Acak Soal</th>                       
                        <th>Tanggal</th>                    
                        <th>Status Quiz</th>   
                        <th>Pembuat</th> 
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php $i=1; foreach ($quiz as $dataQuiz):  ?>
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$dataQuiz->jenis_quiz}}</td>
                        <td>{{$dataQuiz->judul_quiz}}</td>
                        <td>{{$dataQuiz->info_quiz}}</td>
                        <td>{{$dataQuiz->nama_modul}}</td> 
                        <td>{{$dataQuiz->departemen_quiz}}</td>
                        <td>{{$dataQuiz->waktu_quiz}} Menit</td>
                        <td>{{$dataQuiz->jumlah_soal}}</td> 
                        <td>{{$dataQuiz->is_random ? 'Ya' : 'Tidak'}}</td>
                        <td>{{$dataQuiz->tgl_quiz}}</td>
                        <td>{{$dataQuiz->status_quiz}}</td>
                        <td>{{$dataQuiz->pembuat_quiz}}</td>
                        <td>                            
                          <?php if (Auth::user()->level  == 11): ?>                            
                            <a href="{{{ URL::to('admin/quiz/'.$dataQuiz->id_quiz.'/detail') }}}" class="btn btn-primary btn-xs">
                              <span class="glyphicon glyphicon-eye-open"></span> Lihat
                            </a>
                            <a href="{{{ URL::to('admin/quiz/'.$dataQuiz->id_quiz.'/edit') }}}" class="btn btn-warning btn-xs">
                              <span class="glyphicon glyphicon-edit" ></span> Edit 
                            </a>
                            <a href="{{{ action('Admin\QuizController@hapus',[$dataQuiz->id_quiz]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus Data Quiz {{{($i).' - '.($dataQuiz->judul_quiz) }}}?')" class="btn btn-danger btn-xs">
                              <span class="glyphicon glyphicon-trash"></span> Delete
                            </a>
                          <?php elseif (Auth::user()->level  == 12): ?>
                            <a href="{{{ URL::to('trainer/quiz/'.$dataQuiz->id_quiz.'/detail') }}}" class="btn btn-primary btn-xs">
                              <span class="glyphicon glyphicon-eye-open"></span> Lihat
                            </a>
                            <a href="{{{ URL::to('trainer/quiz/'.$dataQuiz->id_quiz.'/edit') }}}" class="btn btn-warning btn-xs">
                              <span class="glyphicon glyphicon-edit" ></span> Edit 
                            </a>
                            <a href="{{{ action('Admin\QuizController@hapus',[$dataQuiz->id_quiz]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus Data Quiz {{{($i).' - '.($dataQuiz->judul_quiz) }}}?')" class="btn btn-danger btn-xs">
                              <span class="glyphicon glyphicon-trash"></span> Delete
                            </a>
                          <?php endif ?>                                                                                     
                        </td>                              
                      </tr>
                      <?php $i++; endforeach  ?> 
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>  
                        <th>Jenis </th>                          
                        <th>Nama</th>  
                        <th>Keterangan</th>
                        <th>Modul</th>          
                        <th>Departemen</th>
                        <th>Waktu</th>
                        <th>Jumlah Soal</th>
                        <th>Acak Soal</th>                       
                        <th>Tanggal</th>                    
                        <th>Status Quiz</th>   
                        <th>Pembuat</th> 
                        <th>Aksi</th>                        
                      </tr>
                    </tfoot>
                  </table>        
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            <?php endif ?>

            <?php if (Auth::user()->level  == 13): ?> 
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title"><strong> Daftar quiz</strong></h3>
                <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                  <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body" style="display: block;">

                <table id="dataTabelQuizTrainee" class="table table-striped table-responsive">
                  <thead>
                    <th>No</th>
                    <th>Modul</th> 
                    <th>Judul</th>
                    <th>Departemen</th>
                    <th>Acak Soal</th>
                    <th>Jumlah Soal</th>
                    <th>Tanggal Quiz</th>
                    <th>Ambil</th>
                  </thead>
                  <tbody>
                  <?php $i=1; foreach ($quizTrainee as $dataQuiz):  ?>                  
                  <tr>
                    <td>{{$i}}</td> 
                    <td>{{$dataQuiz->nama_modul}}</td> 
                    <td>{{$dataQuiz->judul_quiz}}</td>
                    <td>{{$dataQuiz->departemen_quiz}}</td>
                    <td>{{$dataQuiz->is_random ? 'Ya' : 'Tidak'}}</td>
                    <td>{{$dataQuiz->jumlah_soal}}</td>
                    <td>{{date("d F Y",strtotime($dataQuiz->tgl_quiz))}}</td>                    
                    <td>
                      @if(Auth::user()->level === 11)
                      <a href="{{{action('Admin\QuizController@detail', [$dataQuiz->id_quiz]) }}}"
                         class="btn btn-info btn-xs">
                          <span class="glyphicon glyphicon-play"></span> Ambil
                      </a>
                      @else
                      <a href="quiz/{{ $dataQuiz->id_quiz }}/detail"
                        class="btn btn-info btn-xs">
                        <span class="glyphicon glyphicon-play"></span> Ambil
                      </a>
                      @endif
                    </td>
                  </tr>
                  <?php $i++; endforeach  ?> 
                  </tbody>
                </table> 

              </div><!-- /.box-body -->                                      
            </div>

            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title"><strong> Daftar Pengambilan Quiz</strong></h3>
                <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                  <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
            <div class="box-body" style="display: block;">
            @if ($userJawabLembars->isEmpty())
            <div class="">
                @if(!is_array($userJawabLembars))
                <div class="alert alert-warning" align="center"><font color="black"><strong>Anda</strong> Belum Mengikuti Quiz </font></div>
                @endif
            </div>
            @endif
            
            @if (!$userJawabLembars->isEmpty())
            <table id="dataTabelPengambilanQuizTrainee" class="table table-striped table-responsive">
                <thead>
                <th>No</th>
                <th>Modul</th>
                <th>Jenis Quiz</th>
                <th>Judul</th>
                <th>Waktu Pengambilan</th>
                <th>Nilai Akhir</th>
                <th style="width: 15%;">Aksi</th>
                </thead>
                <tbody>
                <?php $i=1; foreach ($userJawabLembars as $userJawabLembar):  ?> 
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    <td>
                      <?php 
                        $quiz = DB::table('quizs')                  
                           ->join('moduls', 'quizs.id_modul', '=', 'moduls.id_modul')
                           ->select('quizs.*', 'moduls.nama_modul')
                           ->where('id_quiz', $userJawabLembar->id_quiz)
                           ->first(); 
                       ?>
                        {{$quiz->nama_modul}} 
                    </td>
                    <td>
                        {{$quiz->jenis_quiz}} 
                    </td>
                    <td>
                        {{$quiz->judul_quiz}} 
                    </td>
                    <td> 
                        {{ date("d F Y H:i:s",strtotime($userJawabLembar->wkt_mulai)) }} 
                    </td>
                    <td> 
                        {{$userJawabLembar->wkt_selesai ? $userJawabLembar->nilai : 'Belum Selesai'}}
                    </td>
                    <td>
                        @if ($userJawabLembar->wkt_selesai)   
                        <div class="btn-group-horizontal">                                            
                        <a href="{{{ URL::to('trainee/quiz/'.$userJawabLembar->id_nilai_quiz_pilgan) }}}"
                           class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-eye-open"></span> Lihat
                        </a>                                             
                        <a href="{{action('Admin\TraineeJawabQuizController@show', array($userJawabLembar->id_quiz))}}"
                           class="btn btn-success btn-xs">
                            <span class="glyphicon glyphicon-align-left"></span> Lihat Ranking
                        </a>
                        </div> 
                        @else
                        <a href="{{action('Admin\SoalQuizController@show', array($userJawabLembar->id_nilai_quiz_pilgan, 0))}}"
                           class="btn btn-info btn-xs">
                            <span class="glyphicon glyphicon-play"></span> Lanjut Mengerjakan
                        </a>
                        @endif

                    </td>
                </tr>
                <?php $i++; endforeach  ?>                 
                </tbody>
            </table>
            @endif

              </div><!-- /.box-body -->            
            </div>
          <?php endif ?>          
        </div><!-- /.col -->
      </div><!-- /.row -->
       

@endsection
@section('script')

<script src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
      $(function () {

        $('#dataTabelQuiz').DataTable({"pageLength": 10, "scrollX": true});
        $('#dataTabelQuizTrainee').DataTable({"pageLength": 10, "scrollX": true});
        $('#dataTabelPengambilanQuizTrainee').DataTable({"pageLength": 10, "scrollX": true});
      });

    </script>

@endsection