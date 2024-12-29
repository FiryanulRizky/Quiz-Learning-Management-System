@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Data Soal Quiz
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

          <?php if (Auth::user()->level  == 13): ?>
            <li class="active">Trainee</li>              
          <?php endif ?>
            <li class="active">Data Soal Quiz</li>
           
          </ol>
@stop
@section('content')
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <?php if (Auth::user()->level  == 11): ?>
                    <h3 class="box-title">Tambah Soal Quiz <a href="{{{ URL::to('admin/tambah_soal_quiz') }}}" class="btn btn-success btn-flat btn-sm" id="tambahSoalQuiz" title="Tambah Soal Quiz"><i class="fa fa-plus"></i></a></h3>                  
                  <?php endif ?>
                  <?php if (Auth::user()->level  == 12): ?>
                    <h3 class="box-title">Tambah Soal Quiz <a href="{{{ URL::to('trainer/tambah_soal_quiz') }}}" class="btn btn-success btn-flat btn-sm" id="tambahSoalQuiz" title="Tambah Soal Quiz"><i class="fa fa-plus"></i></a></h3>                  
                  <?php endif ?>
                </div><!-- /.box-header -->
                
                <div class="box-body">                  

                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#soals_pilihan_ganda" data-toggle="tab">Pilihan Ganda ( {{$countSoalPilgan}} )</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="soals_pilihan_ganda">
                        <br/>
                        <table id="dataTableSoalQuizPilihanGanda" class="table table-striped table-responsive">
                          <thead>
                            <tr>      
                              <th>No</th>  
                              <th>Pertanyaan</th>
                              <th>Jenis Soal</th>
                              <th>Nama Quiz</th>
                              <th>Poin</th>
                              <th>Gambar</th>
                              <th>Pembuat</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                           <?php $i=1; foreach ($soal_quiz as $dataSoalQuiz):  ?>
                            <tr>
                              <td>{{$i}}</td>
                              <td data-toggle="popover" data-trigger="hover" data-content="{{$dataSoalQuiz->pertanyaan}}" >{{\Illuminate\Support\Str::limit(strip_tags($dataSoalQuiz->pertanyaan), 30)}} </td>
                              <td>{{$dataSoalQuiz->jenis_soal}}</td>
                              <td>{{$dataSoalQuiz->judul_quiz}}</td>
                              <td>{{$poin}}</td>                              
                              <td>
                                  <?php if (!$dataSoalQuiz->gambar == ""): ?>
                                    <img src="{{URL::to('upload_gambar/'.$dataSoalQuiz->gambar) }}" alt="" style="width:100px"></td>                                    
                                  <?php endif ?>
                                  <?php if ($dataSoalQuiz->gambar == ""): ?>
                                    Tidak ada Gambar
                                  <?php endif ?>
                                  
                              <td>{{$dataSoalQuiz->pembuat_quiz}}</td>
                              <td>  
                                <div class="btn-group-vertical">
                                  @if(Auth::user()->level  == 11)
                                  <a href="{{{ URL::to('admin/soal_quiz/'.$dataSoalQuiz->id_soal.'/edit') }}}" class="btn btn-warning btn-xs">
                                    <span class="glyphicon glyphicon-edit" ></span> Edit 
                                </a> 
                                <a href="{{{action('Admin\SoalQuizController@detail', [$dataSoalQuiz->id_soal]) }}}" class="btn btn-primary btn-xs">
                                  <span class="glyphicon glyphicon-eye-open"></span> Lihat
                              </a>
                                @elseif(Auth::user()->level  == 12)
                                  <a href="{{{ URL::to('trainer/soal_quiz/'.$dataSoalQuiz->id_soal.'/edit') }}}" class="btn btn-warning btn-xs">
                                    <span class="glyphicon glyphicon-edit" ></span> Edit 
                                </a>
                                <a href="{{{ URL::to('trainer/soal_quiz/'.$dataSoalQuiz->id_soal.'/detail') }}}" class="btn btn-primary btn-xs">
                                  <span class="glyphicon glyphicon-eye-open"></span> Lihat
                              </a>
                                @endif
                                <a href="{{{ action('Admin\SoalQuizController@hapus',[$dataSoalQuiz->id_soal]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus data {{{($i).' - '.($dataSoalQuiz->judul_quiz) }}}?')" class="btn btn-danger btn-xs">
                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                </a>
                                </div>                                                                                                                       
                                </td>                              
                            </tr>
                            <?php $i++; endforeach  ?> 
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>No</th>  
                              <th>Pertanyaan</th>
                              <th>Jenis Soal</th>
                              <th>Nama Quiz</th>
                              <th>Poin</th>
                              <th>Gambar</th>
                              <th>Pembuat</th>
                              <th>Aksi</th>
                            </tr>
                          </tfoot>
                        </table>

                    </div>                  
                </div>                  

                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
       

@endsection
@section('script')

<script src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
      $(function () {

        $('#dataTableSoalQuizPilihanGanda').DataTable({"pageLength": 10, "scrollX": true});
      });

    </script>

@endsection

