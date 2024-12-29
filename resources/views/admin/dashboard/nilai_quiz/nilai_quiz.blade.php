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
          <h3> Data Nilai Quiz</h3>
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Nilai Quiz <a href="{{{ URL::to('admin/tambahnilai_quiz') }}}" class="btn btn-success btn-flat btn-sm" id="tambahNilaiQuiz" title="Tambah"><i class="fa fa-plus"></i></a></h3>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                  <table id="dataTableNilaiQuiz" class="table table-bordered table-hover">
                    <thead>
                      <tr>      
                        <th>No</th>                                         
                        <th>NIK</th>                                               
                        <th>Nama Trainee</th>
                        <th>Modul</th> 
                        <th>Judul Quiz</th>
                        <th>Nilai Quiz</th>                        
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php $i=1; foreach ($nilai_quiz as $dataNilai):  ?>
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$dataNilai->nik_trainee}}</td>
                        <td>{{$dataNilai->nama_trainee}}</td>
                        <td>{{$dataNilai->nama_modul}}</td>
                        <td>{{$dataNilai->judul_quiz}}</td>
                        <td>{{$dataNilai->nilai_quiz}}</td>                        

                        <td><a href="{{{ URL::to('admin/nilai_quiz/'.$dataNilai->id_nilai_quiz_trainee.'/edit') }}}">
                              <span class="label label-warning" ><i class="fa fa-edit" >&nbsp;&nbsp; Edit &nbsp;&nbsp;</i></span>
                              </a> 
                          <a href="{{{ action('Admin\NilaiQuizController@hapus',[$dataNilai->id_nilai_quiz_trainee]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus Data Nilai Quiz  {{{($dataNilai->nik_trainee).' - '.($dataNilai->nama_trainee) }}}?')">
                              <span class="label label-danger"><i class="fa fa-trash">&nbsp;&nbsp; Delete &nbsp;&nbsp;</i></span>
                              </a>                          
                          </td>                              
                      </tr>
                      <?php $i++; endforeach  ?> 
                    </tbody>
                    <tfoot>
                       <tr>      
                        <th>No</th>                                         
                        <th>NIK</th>                                               
                        <th>Nama Trainee</th>
                        <th>Modul</th> 
                        <th>Judul Quiz</th>
                        <th>Nilai Quiz</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                  </table>
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

        $('#dataTableNilaiQuiz').DataTable({"pageLength": 10, "scrollX": true});

      });

    </script>

@endsection

