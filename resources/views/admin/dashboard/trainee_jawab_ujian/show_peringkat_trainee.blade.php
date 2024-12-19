<?php                       
  $trainee = \App\Trainee::where('id_user', Auth::user()->id_user)->first(); // detail field trainee yang sedang login.  
  $id_user_trainee = \App\Trainee::where('nisn_trainee', $userJawabLembars->first()->nisn_trainee)->first()->id_user; // detail field trainee yang sedang login.   
?>
@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Peringkat Ujian Trainee
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

          <?php if (Auth::user()->level  == 13): ?>
            <li class="active">Trainee</li>              
          <?php endif ?>             
            <li class="active">Peringkat Kuis {{ $ujian->judul_ujian }}</li>
          </ol>
@stop

@section('content')
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ $ujian->judul_ujian }}</h3>                  
                </div><!-- /.box-header -->                                                                
                <div class="box-body">
                  <div class="row"> 
                    <br/> 
                   <div class="col-md-12" style="margin-left: 20%;">                                    
                    <div class="col-md-5">                      
                     <table border="0" width="85%">                   
                      <tbody>
                        <tr>
                          <td width="30%"><strong>Modul</strong></td>  
                          <td>: &nbsp;&nbsp; {{$ujian->nama_modul}}</td>                          
                        </tr>                        
                        <tr>
                          <td><strong>Jumlah Soal</strong></td> 
                          <td>: &nbsp;&nbsp; {{$ujian->jumlah_soal}}</td>
                        </tr>                        
                        <tr>
                          <td><strong>Batas Waktu</strong></td>
                          <td>: &nbsp;&nbsp; {{$ujian->waktu_ujian}} Menit</td>
                        </tr>
                        <tr>
                          <td><strong>Departemen</strong></td> 
                          <td>: &nbsp;&nbsp; {{$ujian->departemen_ujian}}</td>                        
                        </tr>
                        <tr>
                          <td><strong>Acak Soal</strong></td> 
                          <td>: &nbsp;&nbsp; {{$ujian->is_random ? 'Ya' : 'Tidak'}}</td> 
                        </tr>                                                                        
                      </tbody>                      
                    </table>
                  </div>

                  <div class="col-md-2" align="pull-right">                    
                   <div class="btn-default btn-lg pull-right" id="btnPopover1" title="Jumlah Pengambilan" data-toggle="tooltip">
                      <h1><span class="glyphicon glyphicon-align-left"></span> {{count($userJawabLembars)}}</h1>
                  </div>
                  </div>
                 </div>
                </div><!-- /.row -->
                <br/>
                <hr> 
                @if ($userJawabLembars->isEmpty())
                <div class="">
                  @if(!is_array($userJawabLembars))
                  <div class="alert alert-warning" align="center"><strong>Maaf</strong> daftar pengambilan ujian tidak ditemukan</div>
                  @endif
                </div>
                @endif                 

                @if (!$userJawabLembars->isEmpty())
                <table class="table table-hover table-responsive">
                    <thead>
                    <th>Peringkat</th>
                    <th>NISN Trainee</th>
                    <th>Waktu Pengambilan</th>
                    <th>Nilai Akhir</th>
                    <th>Waktu Penyelesaian</th>
                    <th>Aksi</th>
                    </thead>
                    <tbody>
                    @foreach($userJawabLembars as $key => $userJawabLembar)
                    <tr class="{{$id_user_trainee == Auth::user()->id_user ? 'success' : ''}}">
                        <td>
                            #{{$key + 1}}
                        </td>
                        <td>
                            {{$userJawabLembar->nisn_trainee}}
                        </td>
                        <td>
                            {{ date("d F Y H:i:s",strtotime($userJawabLembar->wkt_mulai)) }}
                        </td>
                        <td>
                            {{$userJawabLembar->wkt_selesai ? $userJawabLembar->nilai : 'Belum Selesai'}} 
                        </td>
                        <td>
                            {{$userJawabLembar->interval}} 
                        </td>
                        <td>
                          <?php if (Auth::user()->level == 13 and $userJawabLembar->nisn_trainee == $trainee->nisn_trainee): ?>
                            <a href="{{ url('trainee/ujian/'.$userJawabLembar->id_nilai_ujian_pilgan) }}"
                               class="btn btn-primary btn-xs">
                                <span class="glyphicon glyphicon-eye-open"></span> Lihat
                            </a>
                            <?php endif ?>

                         <?php if (Auth::user()->level == 11): ?> 

                            <a href="{{ url('admin/ujian/'.$userJawabLembar->id_nilai_ujian_pilgan) }}"
                               class="btn btn-primary btn-xs">
                                <span class="glyphicon glyphicon-eye-open"></span> Lihat
                            </a>
                                                                                    
                            <a href="{{ url('admin/ujian_trainee/'.$userJawabLembar->id_nilai_ujian_pilgan.'/hapus') }}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus data {{{($key + 1).' - '.($userJawabLembar->nisn_trainee) }}}?')" class="btn btn-danger btn-xs">
                                    <span class="glyphicon glyphicon-remove"></span> Hapus
                                </a>                          
                          <?php endif ?>
                          <?php if (Auth::user()->level == 12): ?>
                            <a href="{{ url('trainer/ujian/'.$userJawabLembar->id_nilai_ujian_pilgan) }}"
                               class="btn btn-primary btn-xs">
                                <span class="glyphicon glyphicon-eye-open"></span> Lihat
                            </a>                                                                                

                            <a href="{{ url('trainer/ujian/'.$userJawabLembar->id_nilai_ujian_pilgan.'/hapus') }}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus data {{{($key + 1).' - '.($userJawabLembar->nisn_trainee) }}}?')" class="btn btn-danger btn-xs">
                                    <span class="glyphicon glyphicon-remove"></span> Hapus
                                </a>                          
                          <?php endif ?>

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif

              </div><!-- /.box-body -->
            </div>
          </div>                       
        </div><!-- /.row -->
@endsection
@section('script')

<script src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
      $(function () {

        $('#dataTableSoalUjian').DataTable({"pageLength": 10, "scrollX": true});
      });

</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#btnPopover1').tooltip();
  });
</script>

@endsection


