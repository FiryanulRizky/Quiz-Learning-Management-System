<!-- Terpaksa Ngoding di View -->
<?php   
  $trainee = \App\Trainee::where('id_user', Auth::user()->id_user)->first(); // detail  trainee yang sedang login.  
?>
@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Daftar Tugas Trainee
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
           <li class="active">Daftar Tugas Trainee</li>
          </ol>
@stop
@section('content')          
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <strong>Daftar Tugas Trainee</strong>                 
                </div><!-- /.box-header -->
                
                <div class="box-body">
                <?php if ( Auth::user()->level  == 11 or  Auth::user()->level  == 12): ?>
                  <table id="dataTabelTugasTrainee" class="table table-bordered table-hover">
                    <thead>
                      <tr align="center">      
                        <th>No</th>
                        <th>Departemen</th>
                        <th>Modul</th>
                        <th>Judul Tugas</th>
                        <th>NIK</th>
                        <th>Nama Trainee</th>                        
                        <th>Nama File</th>
                        <th>Keterangan File</th> 
                        <th>Nilai</th>           
                        <th>Lihat File</th>         
                        <th>Beri Nilai</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php $i=1; foreach ($TraineeJawabTugas as $tugasTrainee):  ?>
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$tugasTrainee->departemen_tugas}}</td>
                        <td>{{$tugasTrainee->nama_modul}}</td>
                        <td>{{$tugasTrainee->judul_tugas}}</td>
                        <td>{{$tugasTrainee->nik_trainee}}</td> 
                        <td>{{$tugasTrainee->nama_trainee}}</td>
                        <td>{{$tugasTrainee->nama_file}}</td>
                        <td>{{$tugasTrainee->judul}}</td>
                        <td>{{$tugasTrainee->nilai}}</td> 
                        <td>
                          <?php if (Auth::user()->level == 11): ?>
                            <a href="{{{ URL::to('admin/tugas/'.$tugasTrainee->id_trainee_jawab_tugas.'/download_tugas_trainee') }}}">
                              <span class="label label-info"><i class="fa fa-print">&nbsp;&nbsp; Download &nbsp;&nbsp;</i></span>
                            </a>
                          <?php endif ?>
                        </td>                                               
                        <td>                         
                          <form id="formTugasNilaiTrainee" class="form-horizontal" role="form" method="POST" action="{{ url('admin/tugas/trainee/'.$tugasTrainee->id_trainee_jawab_tugas.'/update_nilai_tugas') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id_trainee_jawab_tugas" value="{{$tugasTrainee->id_trainee_jawab_tugas}}" >
                            <div class="col-md-3">
                              <input type="text" class="form-control" name="nilai" placeholder="Nilai" style="text-align: center; width: 60px; height: 30px;">
                              <small class="help-block"></small>                                                      
                            <button type="submit" class="btn btn-primary" id="button-reg" style="text-align: center; width: 70px; height: 35px;">
                              Simpan
                            </button>
                            </div> 
                          </form>
                        </td>                              
                      </tr>
                      <?php $i++; endforeach  ?> 
                    </tbody>
                    <tfoot>
                      <tr>      
                        <th>No</th>
                        <th>Departemen</th>
                        <th>Modul</th>
                        <th>Judul Tugas</th>
                        <th>NIK</th>
                        <th>Nama Trainee</th>                        
                        <th>Nama File</th>
                        <th>Keterangan File</th> 
                        <th>Nilai</th>           
                        <th>Lihat File</th>         
                        <th>Beri Nilai</th>
                      </tr>
                    </tfoot>
                  </table>
                  <?php endif ?>                   
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

        $('#dataTabelTugasTrainee').DataTable({"pageLength": 10, "scrollX": true});

      });

    </script>

@endsection

