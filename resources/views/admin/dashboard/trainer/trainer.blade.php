@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Data Trainer
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Admin</li>
            <li class="active">Data Trainer</li>
           
          </ol>
@stop
@section('content')          
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Trainer <a href="{{{ URL::to('admin/tambahtrainer') }}}" class="btn btn-success btn-flat btn-sm" id="tambahTrainer" title="Tambah"><i class="fa fa-plus"></i></a></h3>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                  <table id="dataTabelTrainer" class="table table-bordered table-hover">
                    <thead>
                      <tr>      
                        <th>No</th>                                         
                        <th>NIK</th>                                               
                        <th>Nama</th>
                        <th>Tempat Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama </th>
                        <th>No. Hp</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Jabatan </th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>ID User</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php $i=1; foreach ($trainer as $dataTrainer):  ?>
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$dataTrainer->nik_trainer}}</td>
                        <td>{{$dataTrainer->nama_trainer}}</td>
                        <td>{{$dataTrainer->ttl_trainer}}</td>
                        <td>{{$dataTrainer->jns_kelamin_trainer}}</td>
                        <td>{{$dataTrainer->agama_trainer}}</td>
                        <td>{{$dataTrainer->no_telp_trainer}}</td>
                        <td>{{$dataTrainer->email_trainer}}</td>
                        <td>{{$dataTrainer->alamat_trainer}}</td>
                        <td>{{$dataTrainer->jabatan_trainer}}</td>                        
                        <td><img src="{{URL::to('upload_gambar/'.$dataTrainer->foto_trainer) }}" alt="" style="width:100px"></td>
                        <td>{{$dataTrainer->status_trainer}}</td>                                                                    
                        <td>{{$dataTrainer->id_user}}</td>                                           
                        <td>
                          <a href="{{{ URL::to('admin/trainer/'.$dataTrainer->nik_trainer.'/edit') }}}">
                              <span class="label label-warning" ><i class="fa fa-edit" >&nbsp;&nbsp; Edit &nbsp;&nbsp;</i></span>
                          </a> 
                          <a href="{{{ URL::to('admin/trainer/'.$dataTrainer->nik_trainer.'/detail') }}}">
                              <span class="label label-info"><i class="fa fa-list"> Detail </i></span>
                          </a>
                          <a href="{{{ action('Admin\TrainerController@hapus',[$dataTrainer->nik_trainer]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus Data Trainer {{{($dataTrainer->nik_trainer).' - '.($dataTrainer->nama_trainer) }}}?')">
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
                        <th>Nama</th>
                        <th>Tempat Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama </th>
                        <th>No. Hp</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Jabatan </th>
                        <th>Foto</th>
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

        $('#dataTabelTrainer').DataTable({"pageLength": 10, "scrollX": true});

      });

    </script>

@endsection

