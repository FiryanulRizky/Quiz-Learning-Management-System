@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Data Trainee
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Admin</li>
            <li class="active">Data Trainee</li>
           
          </ol>
@stop
@section('content')
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Trainee <a href="{{{ URL::to('admin/tambahtrainee') }}}" class="btn btn-success btn-flat btn-sm" id="tambahTrainee" title="Tambah"><i class="fa fa-plus"></i></a></h3>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                  <table id="dataTabelTrainee" class="table table-bordered table-hover">
                    <thead>
                      <tr>      
                        <th>No</th>                                         
                        <th>NISN</th>                                               
                        <th>Nama</th>
                        <th>Foto</th>
                        <th>Email</th>
                        <th>No. Hp</th>
                        <th>TTL</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>                        
                        <th>Departemen</th>                        
                        <th>Status</th>
                        <th>ID User</th>                       
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php $i=1; foreach ($trainee as $dataTrainee):  ?>
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$dataTrainee->nisn_trainee}}</td>
                        <td>{{$dataTrainee->nama_trainee}}</td>                        
                        <td><img src="{{URL::to('upload_gambar/'.$dataTrainee->foto_trainee) }}" alt="" style="width:100px"></td>
                        <td>{{$dataTrainee->email_trainee}}</td>
                        <td>{{$dataTrainee->no_hp_trainee}}</td>
                        <td>{{$dataTrainee->ttl_trainee}}</td>
                        <td>{{$dataTrainee->jns_kelamin_trainee}}</td>
                        <td>{{$dataTrainee->alamat_trainee}}</td>
                        <td>{{$dataTrainee->departemen_trainee}}</td>
                        <!-- <td>{{$dataTrainee->foto_trainee}}</td> -->
                        <td>{{$dataTrainee->status_trainee}}</td>
                        <td>{{$dataTrainee->id_user}}</td>
                                                                                                           
                        <td>
                          <a href="{{{ URL::to('admin/trainee/'.$dataTrainee->nisn_trainee.'/edit') }}}">
                              <span class="label label-warning" ><i class="fa fa-edit" >&nbsp;&nbsp; Edit &nbsp;&nbsp;</i></span>
                          </a>
                          <a href="{{{ URL::to('admin/trainee/'.$dataTrainee->nisn_trainee.'/detail') }}}">
                              <span class="label label-info"><i class="fa fa-list"> Detail </i></span>
                        </a> 
                          <a href="{{{ action('Admin\TraineeController@hapus',[$dataTrainee->nisn_trainee]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus Data Trainee {{{($dataTrainee->nisn_trainee).' - '.($dataTrainee->nama_trainee) }}}?')">
                              <span class="label label-danger"><i class="fa fa-trash">&nbsp;&nbsp; Delete &nbsp;&nbsp;</i></span>
                          </a>                          
                        </td>                              
                      </tr>
                      <?php $i++; endforeach  ?> 
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>                                         
                        <th>NISN</th>                                               
                        <th>Nama</th>
                        <th>Foto</th>
                        <th>Email</th>
                        <th>No. Hp</th>
                        <th>TTL</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>                        
                        <th>Departemen</th>                        
                        <th>Status</th>
                        <th>ID User</th>                       
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

        $('#dataTabelTrainee').DataTable({"pageLength": 10, "scrollX": true});

      });

    </script>

@endsection

