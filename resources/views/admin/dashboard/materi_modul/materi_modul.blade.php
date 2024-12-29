@extends('admin.layout.master')
@section('breadcrump')          
        <?php if ( Auth::user()->level  == 11 or  Auth::user()->level  == 12): ?>
        <h1>Data Modul Menu <small>Control panel</small> </h1>          
        <?php endif ?>   
        <?php if (Auth::user()->level  == 13): ?>
          <h1>Data Materi Modul <small>Control panel</small> </h1> 
        <?php endif ?>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>                        
          <?php if ( Auth::user()->level  == 11): ?>
            <li class="active">Admin</li> 
            <li class="active">Data Modul Menu</li>        
          <?php endif ?>

          <?php if (Auth::user()->level  == 12): ?>
            <li class="active">Trainer</li> 
            <li class="active">Data Modul Menu</li>
          <?php endif ?>  

          <?php if (Auth::user()->level  == 13): ?>
            <li class="active">Trainee</li> 
            <li class="active">Data Materi Modul</li>
          <?php endif ?>
          </ol>
@stop
@section('content')                  
          <div class="row">                
            <div class="col-xs-12">
              <div class="box box-danger"><div class="box-header with-border">                
              <?php if ( Auth::user()->level  == 11): ?>                
                <h3 class="box-title">Tambah Modul Menu <a href="{{{ URL::to('admin/tambahmateri_modul') }}}" class="btn btn-success btn-flat btn-sm" id="tambahMateriModul" title="Tambah"><i class="fa fa-plus"></i></a></h3>                
              <?php endif ?>   
              <?php if ( Auth::user()->level  == 12): ?>                
                <h3 class="box-title">Tambah Modul Menu <a href="{{{ URL::to('trainer/tambahmateri_modul') }}}" class="btn btn-success btn-flat btn-sm" id="tambahMateriModul" title="Tambah"><i class="fa fa-plus"></i></a></h3>                
              <?php endif ?>   
              <?php if (Auth::user()->level  == 13): ?>                
                 <h3 class="box-title"><strong> Daftar Materi Modul </strong></h3>
              <?php endif ?>               
               </div><!-- /.box-header -->  
                <div class="box-body">
                  <table id="dataTabelMateriModul" class="table table-bordered table-hover">
                    <thead>
                      <tr>      
                        <th>No</th>  
                        <th>Modul</th>
                        <th>Departemen</th>                                       
                        <th>Judul Materi</th>                                               
                        <th>Nama File Materi</th>                                       
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php $i=1; foreach ($materi_modul as $dataMateriModul):  ?>
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$dataMateriModul->nama_modul}}</td>
                        <td>{{$dataMateriModul->materi_departemen}}</td>
                        <td>{{$dataMateriModul->materi_judul}}</td>
                        <td>{{$dataMateriModul->materi_nama}}</td>
                        <td>
                          <?php if (Auth::user()->level  == 13): ?>                          
                          <a href="{{{ URL::to('trainee/materi_modul/'.$dataMateriModul->id_materi_modul.'/download') }}}"
                               class="btn btn-primary btn-xs">
                                <span class="fa fa-print"></span> Download
                          </a>
                          <?php endif ?>
                          <?php if ( Auth::user()->level  == 11 ): ?>
                            <a href="{{{ URL::to('admin/materi_modul/'.$dataMateriModul->id_materi_modul.'/download') }}}">
                                <span class="label label-info"><i class="fa fa-print">&nbsp;&nbsp; Download &nbsp;&nbsp;</i></span>                             
                            </a>
                            <a href="{{{ URL::to('admin/materi_modul/'.$dataMateriModul->id_materi_modul.'/edit') }}}">
                                <span class="label label-warning" ><i class="fa fa-edit" >&nbsp;&nbsp; Edit &nbsp;&nbsp;</i></span>
                            </a>                           
                            <a href="{{{ action('Admin\MateriModulController@hapus',[$dataMateriModul->id_materi_modul]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus Data MateriModul {{{($dataMateriModul->materi_judul).' - '.($dataMateriModul->materi_nama) }}}?')">
                                <span class="label label-danger"><i class="fa fa-trash">&nbsp;&nbsp; Delete &nbsp;&nbsp;</i></span>
                            </a> 
                          <?php endif ?>

                          <?php if ( Auth::user()->level  == 12 ): ?>
                            <a href="{{{ URL::to('trainer/materi_modul/'.$dataMateriModul->id_materi_modul.'/download') }}}">
                                <span class="label label-info"><i class="fa fa-print">&nbsp;&nbsp; Download &nbsp;&nbsp;</i></span>                             
                            </a>
                            <a href="{{{ URL::to('trainer/materi_modul/'.$dataMateriModul->id_materi_modul.'/edit') }}}">
                                <span class="label label-warning" ><i class="fa fa-edit" >&nbsp;&nbsp; Edit &nbsp;&nbsp;</i></span>
                            </a>                           
                            <a href="{{{ action('Admin\MateriModulController@hapus_trainer',[$dataMateriModul->id_materi_modul]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus Data MateriModul {{{($dataMateriModul->materi_judul).' - '.($dataMateriModul->materi_nama) }}}?')">
                                <span class="label label-danger"><i class="fa fa-trash">&nbsp;&nbsp; Delete &nbsp;&nbsp;</i></span>
                            </a> 
                          <?php endif ?>
                        </td>                              
                      </tr>
                      <?php $i++; endforeach  ?> 
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>  
                        <th>Modul</th>
                        <th>Departemen</th>                                       
                        <th>Judul Materi</th>                                               
                        <th>Nama File Materi</th>                                       
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

        $('#dataTabelMateriModul').DataTable({"pageLength": 10, "scrollX": true});

      });

    </script>

@endsection

