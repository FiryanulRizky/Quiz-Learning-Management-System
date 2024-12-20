@extends('admin.layout.master')
@section('breadcrump')          
        <?php if ( Auth::user()->level  == 11 or  Auth::user()->level  == 12): ?>
          <h1> Detail Trainee         
        <?php endif ?>   
        <?php if (Auth::user()->level  == 13): ?>
          <h1> Biodata Diri Trainee 
        <?php endif ?>
          <small>Control panel</small> </h1> 
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
            <li class="active">Detail Trainee</li>
          </ol>
@stop
@section('content')          
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
                <div class="box-header with-border">  
                  <div class="pull-left">
                    <?php if ( Auth::user()->level  == 11 or  Auth::user()->level  == 12): ?>                
                      <strong> Biodata Diri </strong> {{$nama_trainee}}
                    <?php endif ?>   
                    <?php if (Auth::user()->level  == 13): ?>                
                       <strong> Biodata Diri  </strong> {{$nama_trainee}}
                    <?php endif ?> 
                  </div>
                  <div class="pull-right"> 
                    <?php if (Auth::user()->id_user  == $id_user): ?> 
                    <a href="{{ URL::to('trainee/trainee/edit') }}"
                       class="btn btn-primary btn-xs">
                        <span class="fa fa-gear"></span> Ubah Profile
                    </a>
                    <a href="{{ URL::to('trainee/trainee/ubahpassword') }}"
                       class="btn btn-success btn-xs">
                        <span class="fa fa-gear"></span> Ubah Password
                    </a>
                    <?php endif ?>   
                  </div>
                </div><!-- /.box-header -->
                            
                <div class="box-body">
                  <div class="row">
                    <br>
                    <div class="col-md-12" style="margin-left: -2%">
                    <div class="col-md-3">
                      <p align="center">
                        <img src="{{URL::to('upload_gambar/'.$foto_trainee) }}" alt="" style="width:220px; height:260px">
                        <a class="users-list-name" href="#">{{$nama_trainee}}</a>
                        <span class="users-list-date">Status Trainee : {{$status_trainee}}</span>
                      </p>
                    </div><!-- /.col -->
                    <div class="col-md-9" align="left" >
                     <table id="dataTrainee" class="table table-bordered table-hover">                    
                      <tbody>
                        <tr>
                          <td width="20%">NIK</td>  
                          <td>{{$nik_trainee}}</td>                          
                        </tr>
                        <tr>
                          <td>Nama</td> 
                          <td>{{$nama_trainee}}</td>
                        </tr>
                        <tr>
                          <td>Jenis Kelamin</td> 
                          <td>{{$jns_kelamin_trainee}}</td>
                        </tr>                        
                        <tr>
                          <td>E-Mail</td>
                          <td>{{$email_trainee }}</td>
                        </tr>
                        <tr>
                          <td>Departemen</td> 
                          <td>{{$departemen_trainee}}</td>                        
                        </tr>
                        <tr>
                          <td>Nomor HP</td> 
                          <td>{{$no_hp_trainee}}</td> 
                        </tr> 
                        <tr>
                          <td>Tempat Tanggal Lahir</td> 
                          <td>{{$ttl_trainee}}</td> 
                        </tr> 
                                                                     
                      </tbody>                      
                    </table>
                    </div><!-- /.col -->
                  </div><!-- /.col md-12 -->
                  </div><!-- /.row -->
                </div><!-- /.box-body -->
                 
              </div>
            </div>
                       
          </div><!-- /.row -->

@endsection
@section('script')

  

@endsection

