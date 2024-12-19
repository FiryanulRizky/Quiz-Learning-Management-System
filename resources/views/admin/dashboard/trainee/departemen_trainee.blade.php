@extends('admin.layout.master')
@section('breadcrump')                     
        <?php if (Auth::user()->level  == 13): ?>
          <h1> Departemen anda "{{ $departemen_trainee }}" <small>Control panel</small> </h1> 
        <?php endif ?>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>                                  

          <?php if (Auth::user()->level  == 13): ?>
            <li class="active">Trainee</li> 
            <li class="active">Departemen anda "{{ $departemen_trainee }}"</li>
          <?php endif ?>
          </ol>
@stop
@section('content')                  
          <div class="row">                
            <div class="col-xs-12">
              <div class="box box-danger">
              <div class="box-header with-border" >                              
                <?php if (Auth::user()->level  == 13): ?>                           
                    <class="box-title"><strong> Daftar Modul </strong>
                <?php endif ?>                              
               </div><!-- /.box-header -->                 
                <div class="box-body">                  
                  <table id="dataTabelModul" class="table table-bordered table-hover">
                    <thead>
                      <tr>      
                        <th style="text-align: left; width: 5%;">No</th>                                                                
                        <th style="text-align: center; width: 95%;">Modul</th>  
                      </tr>
                    </thead>
                    <tbody >
                     <?php $i=1; foreach ($departemen as $dataDepartemen):  ?>
                      <tr>
                        <td style="text-align: left;">{{$i}}</td>                      
                        <td style="text-align: center;">{{$dataDepartemen->nama_modul}}</td>                                                                               
                      </tr>
                      <?php $i++; endforeach  ?> 
                    </tbody>                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <div class="box box-danger">
              <div class="box-header with-border" >                              
                <?php if (Auth::user()->level  == 13): ?>                           
                    <class="box-title"><strong> Daftar Trainee </strong>
                <?php endif ?>                              
               </div><!-- /.box-header -->                 
                <div class="box-body">                  
                  <table id="dataTabelTrainee" class="table table-bordered table-hover">
                    <thead>
                      <tr>      
                        <th>No</th>                                         
                        <th>NISN</th>                                               
                        <th>Nama</th>                        
                        <th>Email</th>
                        <th>No. Hp</th>
                        <th>TTL</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>                         
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php $i=1; foreach ($trainee as $dataTrainee):  ?>
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$dataTrainee->nik_trainee}}</td>
                        <td>{{$dataTrainee->nama_trainee}}</td>                        
                        <td>{{$dataTrainee->email_trainee}}</td>
                        <td>{{$dataTrainee->no_hp_trainee}}</td>
                        <td>{{$dataTrainee->ttl_trainee}}</td>
                        <td>{{$dataTrainee->jns_kelamin_trainee}}</td>
                        <td>{{$dataTrainee->alamat_trainee}}</td>                                               
                        <td>                         
                          <a href="{{{ URL::to('trainee/trainee/'.$dataTrainee->nik_trainee.'/detail') }}}">
                              <span class="label label-info"><i class="fa fa-list"> Detail </i></span>
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
                        <th>Email</th>
                        <th>No. Hp</th>
                        <th>TTL</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>                         
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

        $('#dataTabelTrainee').DataTable({"pageLength": 10}); //, "scrollX": true
        $('#dataTabelModul').DataTable({"pageLength": 10}); //, "scrollX": true

      });

    </script>

@endsection

