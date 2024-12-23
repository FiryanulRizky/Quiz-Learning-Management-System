<!-- Terpaksa Ngoding di View -->
<?php 
  $i = Auth::user()->level;
  $idUser = Auth::user()->id_user;                         
  $trainee = \App\Trainee::where('id_user', $idUser)->first(); // detail field trainee yang sedang login.
  $trainer = \App\Trainer::where('id_user', $idUser)->first(); // detail field trainee yang sedang login.
?>       
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{URL::to('upload_gambar/'.$trainer->foto_trainer) }}" class="img-circle" alt="User Image" style="height:45px; width:45px;">
            </div>
            <div class="pull-left info">
              <p>Trainer</p>
              <a ><i class="fa fa-circle text-success"></i> {{ Auth::user()->username }}</a>
            </div>
          </div>

          <!-- Sidebar Menu Header-->
        <ul class="sidebar-menu">
            <li class="header" style=" text-align: center;"> <font color = "white";"><b>MAIN NAVIGATION TRAINER </b> </font> </li>
            <!-- Optionally, you can add icons to the links -->
            <li class="@if(url('/') == request()->url()) active @else '' @endif"><a href="{{ url('/') }}">
              <i class='fa fa-dashcube'></i> <span>Dashboard</span></a>
            </li>

            <!-- Menu Admin-->
            <!-- Pilihan, untuk menampilkan menu yang dapat digunakan oleh 3 jenis pengguna, yaitu admin, trainer, dan trainee -->

            <li class="treeview active ">
              <a href="{{{URL::to('trainer/modul_learn')}}}">
                <i class="fa fa-list-alt"></i>
                <span>Kelola Modul</span>
                <span class="label label-primary pull-right">5</span>
              </a>
              <ul class="treeview-menu">
                <li class="@if(url('trainer/departemen') == request()->url() ) active @else '' @endif">
                  <a href="{{{URL::to('trainer/departemen')}}}"><i class="fa fa-plus-square">                    
                  </i> Departemen Anda </a>
                </li>

                <li class="@if(url('trainer/materi_ajar') == request()->url() ) active @else '' @endif">
                  <a href="{{{URL::to('trainer/materi_ajar')}}}"><i class="fa fa-plus-square">                    
                  </i> Materi Ajar Trainee</a>
                </li>                
                
                <li class="@if(url('trainer/tugas') == request()->url() ) active @else '' @endif">
                  <a href="{{{URL::to('trainer/tugas')}}}"><i class="fa fa-plus-square">                    
                  </i> Tugas Trainee</a>
                </li>

                <li class="@if(url('trainer/ujian') == request()->url() ) active @else '' @endif">
                  <a href="{{{URL::to('trainer/ujian')}}}"><i class="fa fa-plus-square">                    
                  </i> Ujian Trainee</a>
                </li>

                <li class="@if(url('trainer/soal_ujian') == request()->url() or url('trainer/tambah_soal_ujian')  == request()->url() ) active @else '' @endif">
                  <a href="{{{URL::to('trainer/soal_ujian')}}}"><i class="fa fa-plus-square">                    
                  </i> Soal Ujian Trainee</a>
                </li>

                <li class="@if(url('trainer/nilai_trainee') == request()->url() ) active @else '' @endif">
                  <a href="{{{URL::to('trainer/nilai_trainee')}}}"><i class="fa fa-plus-square">                    
                  </i> Nilai Trainee</a>
                </li>                
              </ul>
            </li>            

        </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
