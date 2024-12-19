@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Data Modul
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Admin</li>
            <li class="active">Data Modul</li>
           
          </ol>
@stop
@section('content')
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Modul <a href="{{{ URL::to('admin/tambahmodul_learn') }}}" class="btn btn-success btn-flat btn-sm" id="tambahModul" title="Tambah"><i class="fa fa-plus"></i></a></h3>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                  <table id="dataTabelModul" class="table table-bordered table-hover">
                    <thead>
                      <tr>      
                        <th>No</th>
                        <th>Nama Modul</th>  
                        <th>Nama Trainer Pengajar</th>
                        <th>Aksi</th>                      
                      </tr>
                    </thead>
                    <tbody>
                     <?php $i=1; foreach ($modul as $dataModul):  ?>
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$dataModul->nama_modul}}</td>
                        <td>{{$dataModul->nama_trainer}}</td>                                                                                                               
                        <td><a href="{{{ URL::to('admin/modul_learn/'.$dataModul->id_modul.'/edit') }}}">
                              <span class="label label-warning" ><i class="fa fa-edit" >&nbsp;&nbsp; Edit &nbsp;&nbsp;</i></span>
                              </a> 
                          <a href="{{{ action('Admin\ModulController@hapus',[$dataModul->id_modul]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus Data Modul {{{($dataModul->id_modul).' - '.($dataModul->nama_modul) }}}?')">
                              <span class="label label-danger"><i class="fa fa-trash">&nbsp;&nbsp; Delete &nbsp;&nbsp;</i></span>
                              </a>                          
                          </td>                              
                      </tr>
                      <?php $i++; endforeach  ?> 
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Nama Modul</th>  
                        <th>Nama Trainer Pengajar</th>
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

        $('#dataTabelModul').DataTable({"pageLength": 10, "scrollX": true});

      });

    </script>

@endsection

