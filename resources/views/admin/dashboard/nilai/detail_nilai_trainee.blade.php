@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Nilai Trainee "{{$trainee->departemen_trainee}}" - "{{$trainee->nama_trainee}}"
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Trainee</li>
            <li class="active">Nilai Trainee "{{$trainee->departemen_trainee}}" - "{{$trainee->nama_trainee}}"</li>           
          </ol>
@stop
@section('content')
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <div class="box-header">               
                    <form id="formDepartemenModul_learn" class="form-horizontal" role="form" method="POST" action="{{ route('trainee.post_nilai')}}");>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                      <label class="col-md-4 control-label">Pilih Modul</label>
                      <div class="col-md-4">  
                        <select class="form-control " name="modul_learn_terpilih" style="font-size: 14px; text-align: left;">
                         @foreach ($listModul_learn as $dataModul_learn)
                          <option value="{{$dataModul_learn->nama_modul}}"  @if($modul_learn_terpilih == $dataModul_learn->nama_modul) ? ' selected="selected"' : '' @endif > {{$dataModul_learn->nama_modul}}</option>                          
                         @endforeach
                        </select>                                   
                      <small class="help-block"></small>
                      </div>                          
                      <div class="col-md-4">                         
                          <button type="submit" class="btn btn-flat btn-social btn-dropbox" id="button-reg">
                                <i class="fa  fa-hand-o-left"></i> Pilih
                          </button>
                      </div>                                               
                    </div>                    
                    </form>                
                  </div><!-- /.box-header -->

                <div class="box-body"> 
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#nilai_tugas" data-toggle="tab">Nilai Tugas</a></li>
                  <li ><a href="#nilai_ujian" data-toggle="tab">Nilai Ujian</a></li>
                </ul>

                <!-- Tab panes 1 -->
                <div class="tab-content">
                  <div class="tab-pane fade in active" id="nilai_tugas">
                    <br/>                    
                    @if (!count($nilaiTugas)<=1)
                    <table id="dataTabelNilaiTugas" class="table table-bordered table-hover">
                      <thead>
                        <tr>      
                          <th>No</th>                          
                          <th style="width: 15%;">Modul</th>
                          <th style="width: 30%;">Judul Tugas</th>
                          <th>NISN</th>                                     
                          <th>Nama Trainee</th>                        
                          <th>Nilai Tugas</th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php $i=1; foreach ($nilaiTugas as $dataNilaiTugas):  ?>
                        <tr>
                          <td>{{$i}}</td>
                          <td>{{$dataNilaiTugas->nama_modul}}</td>
                          <td>{{$dataNilaiTugas->judul_tugas}}</td>
                          <td>{{$dataNilaiTugas->nik_trainee}}</td>
                          <td>{{$dataNilaiTugas->nama_trainee}}</td>                        
                          <td>{{$dataNilaiTugas->nilai}}</td>                                                    
                        </tr>
                        <?php $i++; endforeach  ?> 
                      </tbody>
                    </table>
                    @endif                   
                  </div>
                  <div class="tab-pane fade" id="nilai_ujian">
                    <br/>                    
                    @if (!count($nilaiUjian)<=1)
                    <table id="dataTabelNilaiUjian" class="table table-bordered table-hover">
                      <thead>
                        <tr>      
                          <th >No</th>
                          <th style="width: 15%;">Modul</th>
                          <th style="width: 30%;">Judul Ujian</th>
                          <th>Jenis</th>                                     
                          <th>NISN</th> 
                          <th>Nama Trainee</th>                        
                          <th>Nilai Ujian</th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php $i=1; foreach ($nilaiUjian as $dataNilaiUjian):  ?>
                        <tr>
                          <td>{{$i}}</td>
                          <td>{{$dataNilaiUjian->nama_modul}}</td>
                          <td>{{$dataNilaiUjian->judul_ujian}}</td>
                          <td>{{$dataNilaiUjian->jenis_ujian}}</td>
                          <td>{{$dataNilaiUjian->nik_trainee}}</td>
                          <td>{{$dataNilaiUjian->nama_trainee}}</td>                        
                          <td>{{$dataNilaiUjian->nilai}}</td>                                                    
                        </tr>
                        <?php $i++; endforeach  ?> 
                      </tbody>
                    </table>
                    @endif                    
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
        $('#dataTabelNilaiTugas').DataTable({"pageLength": 10}); //, "scrollX": true
        $('#dataTabelNilaiUjian').DataTable({"pageLength": 10}); //, "scrollX": true

      });

    </script>

@endsection

