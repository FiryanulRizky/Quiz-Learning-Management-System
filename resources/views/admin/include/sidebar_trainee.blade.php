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
          <!-- Sidebar user panel --> <!-- $dataTrainee->foto_trainee -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{URL::to('upload_gambar/'.$trainee->foto_trainee) }}" class="img-circle" alt="User Image" style="height:45px; width:45px;">
                </div>
            <div class="pull-left info">
              <p>Trainee</p>
              <a ><i class="fa fa-circle text-success"></i> {{ Auth::user()->username }}</a>
            </div>
          </div>

          <!-- Sidebar Menu Header-->
        <ul class="sidebar-menu">
            <li class="header" style=" text-align: center;"> <font color = "white";"><b>MAIN NAVIGATION TRAINEE </b> </font> </li>
            <!-- Optionally, you can add icons to the links -->
            <li class="@if(url('/') == request()->url()) active @else '' @endif"><a href="{{ url('/') }}">
              <i class='fa fa-dashcube'></i> <span>Dashboard</span></a>
            </li>

            <!-- Menu Trainee-->
            <!-- Untuk menampilkan menu yang dapat digunakan oleh trainee -->
            <li class="@if(url('trainee/pengumuman') == request()->url() or url('trainee/tambahpengumuman') == request()->url() or url('trainee/pengumuman/1/edit') == request()->url() or url('trainee/pengumuman/2/edit') == request()->url() or url('trainee/pengumuman/3/edit') == request()->url() or url('trainee/pengumuman/4/edit') == request()->url() or url('trainee/pengumuman/5/edit') == request()->url() ) active @else '' @endif"><a href="{{ url('trainee/pengumuman') }}">
            <i class='fa fa-bullhorn'></i> <span> Pengumuman</span></a>
           </li>

            <li class="@if(url('trainee/departemen_trainee') == request()->url() or url('trainee/tambahmateri_ajar')  == request()->url() ) active @else '' @endif">
              <a href="{{{URL::to('trainee/departemen_trainee')}}}"><i class="fa fa-home">                    
              </i> Departemen Anda </a>
            </li> 

            <li class="@if(url('trainee/materi_ajar') == request()->url() or url('trainee/tambahmateri_ajar')  == request()->url() ) active @else '' @endif">
              <a href="{{{URL::to('trainee/materi_ajar')}}}"><i class="fa fa-list-ol">                    
              </i> Materi Modul</a>
            </li>                             
                
            <li class="@if(url('trainee/tugas') == request()->url() or url('trainee/tambahtugas')  == request()->url() or url('trainee/message/send') == request()->url()) active @else '' @endif">
              <a href="{{{URL::to('trainee/tugas')}}}"><i class="fa fa-tasks">                    
              </i> Tugas</a>
            </li>

            <li class="@if(url('trainee/ujian') == request()->url() or url('trainee/tambahujian')  == request()->url() ) active @else '' @endif">
              <a href="{{{URL::to('trainee/ujian')}}}"><i class="fa fa-edit">                    
              </i> Ujian</a>
            </li>

            <li class="@if(url('trainee/nilai') == request()->url() or url('trainee/nilai') == request()->url() ) active @else '' @endif">
              <a href="{{{URL::to('trainee/nilai')}}}"><i class="fa  fa-check-square-o">                    
              </i>Nilai </a>
            </li>

        </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
