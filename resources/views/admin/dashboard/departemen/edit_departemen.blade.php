@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Edit Data Departemen
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Admin</li>
          </ol>
@stop
@section('content')
          <div class="row">
            <div class="col-md-12">
                <div class="uk-alert uk-alert-success" data-uk-alert>
                    <a href="" class="uk-alert-close uk-close"></a>
                    <p>{{  isset($successMessage) ? $successMessage : '' }}</p>
                     @if (count($errors) > 0)
                        <div class="alert alert-danger" align="center">
                            <strong>Maaf!</strong> Sebelum Menekan tombol "Simpan" Anda Harus Melengkapi data dibawah ini dahulu :
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Form Edit Data Departemen</h3>
                </div><!-- /.box-header -->
                <div style="display: block; " class="box-body">                         
                 <form id="formDepartemenEdit" class="form-horizontal" role="form" method="POST" action="{{ url('admin/departemen/'.$id.'/simpanedit') }}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="id" value="{{$id}}" >                       

                  <div class="col-md-12" style="margin-left:8%;">
                      <div class="form-group">
                       <label class="col-sm-1  control-label" style="text-align: left;">Departemen</label>
                       <div class="col-sm-9">               
                        <select class="form-control " name="nama_departemen" style="font-size: 14px; text-align: left;">
                         <option value="{{ $nama_departemen }}">-- {{ $nama_departemen }} --</option>
                         <option value="Manajemen"> Manajemen </option>
                         <option value="Marketing"> Marketing </option>
                         <option value="Operasional"> Operasional </option>
                         <option value="Billing"> Billing </option>
                         <option value="Account Payable"> Account Payable </option>
                         <option value="Account Receivable"> Account Receivable </option>
                         <option value="Warehouse Inventory"> Warehouse Inventory </option>
                         <option value="Fleet Yard"> Fleet Yard </option>                   
                        </select>
                       </div>
                      </div>                      

                    <div class="form-group">
                     <label class="col-sm-1 control-label" style="text-align: left;">ID Modul_learn</label>
                     <div class="col-sm-9">               
                      <select class="form-control" name="id_modul" style="font-size: 14px; text-align: left;">
                       <option value="{{ $id_modul }}">-- {{ $id_modul }}  --</option>
                       @foreach ($Modul_learn as $idModul_learn)
                          <option value="{{ $idModul_learn->id_modul }}">id modul : {{ $idModul_learn->id_modul }} | nama : {{ $idModul_learn->nama_modul }}</option>
                       @endforeach                                                                                 
                      </select>
                     </div>   
                    </div>                     
                                            
                    </div>
                    </div><!-- /.box-body -->

                      <div style="display: block;" class="box-footer" >
                          <div class="form-group">
                          <div class="col-md-8 col-md-offset-5">
                              <button type="submit" class="btn btn-primary" id="button-reg">
                                  Simpan
                              </button>

                              <a href="{{{ action('Admin\DepartemenController@index') }}}" title="Cancel">
                              <span class="btn btn-default"><i class="fa fa-back"> Cancel </i></span>
                              </a> 
                          </div>
                      </div>
                        </div><!-- /.box-footer-->
                  </form>                   
                </div><!-- /.box -->
            </div>
          </div><!-- /.row (main row) -->
                        
@endsection


