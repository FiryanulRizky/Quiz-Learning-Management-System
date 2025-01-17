@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Biodata Diri Trainer
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

            <li class="active">Biodata Diri Trainer</li>
          </ol>
@stop
@section('content')          
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <div class="pull-left">
                      <strong> Biodata Diri </strong> {{$nama_trainer}}
                  </div>
                  <div class="pull-right"> 
                    
                  </div>
                  <div class="pull-right"> 
                    <?php if (Auth::user()->id_user  == $id_user): ?> 
                    <a href="{{ URL::to('trainer/trainer/edit') }}"
                       class="btn btn-primary btn-xs">
                        <span class="fa fa-gear"></span> Ubah Profile
                    </a>
                    <a href="{{ URL::to('trainer/trainer/ubahpassword') }}"
                       class="btn btn-success btn-xs">
                        <span class="fa fa-gear"></span> Ubah Password
                    </a>  
                    <?php endif ?>   
                  </div>                  
                </div><!-- /.box-header -->
                 <?php foreach ($trainer as $itemTrainer);  ?>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3">
                      <p align="center">
                        <img src="{{URL::to('upload_gambar/'.$foto_trainer) }}" alt="" style="width:220px">
                        <a class="users-list-name" href="#">{{$nama_trainer}}</a>
                        <span class="users-list-date">Status Trainer : {{$status_trainer}}</span>
                      </p>
                    </div><!-- /.col -->
                    <div class="col-md-9">
                     <table align="center" id="dataTrainer" class="table table-bordered table-hover">                    
                      <tbody>
                        <tr>
                          <td width="40%">NIK</td>  
                          <td>{{$nik_trainer}}</td>                          
                        </tr>
                        <tr>
                          <td>Nama</td> 
                          <td>{{$nama_trainer}}</td>
                        </tr>
                        <tr>
                          <td>Jenis Kelamin</td> 
                          <td>{{$jns_kelamin_trainer}}</td>
                        </tr>                        
                        <tr>
                          <td>E-Mail</td>
                          <td>{{$email_trainer }}</td>
                        </tr>
                        <tr>
                          <td>Jabatan</td> 
                          <td>{{$jabatan_trainer}}</td>                        
                        </tr>
                        <tr>
                          <td>Nomor HP</td> 
                          <td>{{$no_telp_trainer}}</td> 
                        </tr> 
                        <tr>
                          <td>Tempat Tanggal Lahir</td> 
                          <td>{{$ttl_trainer}}</td> 
                        </tr> 
                                                                     
                      </tbody>                      
                    </table>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- /.box-body -->
                 
              </div>
            </div>
                       
          </div><!-- /.row -->

@endsection
@section('script')

  

@endsection

