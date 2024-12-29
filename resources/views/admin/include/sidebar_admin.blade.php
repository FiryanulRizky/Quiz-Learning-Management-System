      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{asset('/img/avatar5.png')}}" class="img-circle" alt="User Image" />
                </div>
            <div class="pull-left info">
              <p>Admin</p>
              <a ><i class="fa fa-circle text-success"></i> {{ Auth::user()->name }}</a>
            </div>
          </div>

          <!-- Sidebar Menu Header-->
        <ul class="sidebar-menu">
            <li class="header" style=" text-align: center;"> <font color = "white";"><b>MAIN NAVIGATION ADMIN </b> </font> </li>
            <!-- Optionally, you can add icons to the links -->
            <li class="@if(url('/') == request()->url()) active @else '' @endif"><a href="{{ url('/') }}">
              <i class='fa fa-dashcube'></i> <span>Dashboard </span></a>
            </li>

            <!-- Menu Admin-->
            <!-- Pilihan, untuk menampilkan menu yang dapat digunakan oleh 3 jenis pengguna, yaitu admin, trainer, dan trainee -->
           <li class="@if(url('admin/user') == request()->url() or url('admin/tambahuser') == request()->url() or url('admin/user/1/edit') == request()->url() or url('admin/user/2/edit') == request()->url() or url('admin/user/3/edit') == request()->url() or url('admin/user/4/edit') == request()->url() or url('admin/user/5/edit') == request()->url() ) active @else '' @endif"><a href="{{ url('admin/user') }}">
            <i class='fa fa-user'></i> <span>Kelola Pengguna</span></a>
           </li>  

           <li class="@if(url('admin/departemen') == request()->url() or url('admin/tambahdepartemen') == request()->url() or url('admin/departemen/1/edit') == request()->url() or url('admin/departemen/2/edit') == request()->url() or url('admin/departemen/3/edit') == request()->url() or url('admin/departemen/4/edit') == request()->url() or url('admin/departemen/5/edit') == request()->url() ) active @else '' @endif"><a href="{{ url('admin/departemen') }}">
            <i class='fa fa-home'></i> <span>Kelola Departemen</span></a>
           </li>         
                                                                                       
           <li class="@if(url('admin/pengumuman') == request()->url() or url('admin/tambahpengumuman') == request()->url() or url('admin/pengumuman/1/edit') == request()->url() or url('admin/pengumuman/2/edit') == request()->url() or url('admin/pengumuman/3/edit') == request()->url() or url('admin/pengumuman/4/edit') == request()->url() or url('admin/pengumuman/5/edit') == request()->url() ) active @else '' @endif"><a href="{{ url('admin/pengumuman') }}">
            <i class='fa fa-bullhorn'></i> <span>Kelola Pengumuman</span></a>
           </li>

           <li class="@if(url('admin/trainee') == request()->url() or url('admin/tambahtrainee') == request()->url() or url('admin/trainee/1/edit') == request()->url() or url('admin/trainee/2/edit') == request()->url() or url('admin/trainee/3/edit') == request()->url() or url('admin/trainee/4/edit') == request()->url() or url('admin/trainee/5/edit') == request()->url() ) active @else '' @endif"><a href="{{ url('admin/trainee') }}">
            <i class='fa fa-users'></i> <span>Kelola Trainee</span></a>
           </li>

           <li class="@if(url('admin/trainer')  == request()->url() or url('admin/tambahtrainer')  == request()->url() ) active @else '' @endif"><a href="{{ url('admin/trainer') }}">
            <i class='fa fa-user-plus'></i> <span>Kelola Trainer</span></a>
           </li>                                 

            <li class="@if(url('admin/modul_learn') == request()->url() or url('admin/materi_modul') == request()->url() or url('admin/tugas') == request()->url() or url('admin/message/send') == request()->url() or url('admin/quiz') == request()->url() or url('admin/nilai') == request()->url() or url('admin/nilai_tugas')  == request()->url() or url('admin/nilai_quiz')  == request()->url() or url('admin/tambahmodul_learn')  == request()->url()or url('admin/tambahmateri_modul')  == request()->url() or url('admin/tambahtugas')  == request()->url() or url('admin/tambahquiz')  == request()->url() or url('admin/tambahnilai') == request()->url() or url('admin/tambahnilai_tugas')  == request()->url() or url('admin/tambahnilai_quiz')  == request()->url() or url('admin/soal_quiz') == request()->url() or url('admin/tambah_soal_quiz')  == request()->url() or url('admin/nilai_trainee') == request()->url()) treeview active @else '' @endif">
              <a href="">
                <i class="fa fa-list-alt"></i>
                <span>Kelola Modul</span>
                <span class="label label-primary pull-right">6</span>
              </a>
              <ul class="treeview-menu">    
                <li class="@if(url('admin/modul_learn') == request()->url() or url('admin/tambahmodul_learn')  == request()->url() ) active @else '' @endif">
                  <a href="{{{URL::to('admin/modul_learn')}}}"><i class="fa fa-plus-square">                    
                  </i> Kelola Modul</a>
                </li>

                <li class="@if(url('admin/materi_modul') == request()->url() or url('admin/tambahmateri_modul')  == request()->url() ) active @else '' @endif">
                  <a href="{{{URL::to('admin/materi_modul')}}}"><i class="fa fa-plus-square">                    
                  </i> Kelola Modul Menu</a>
                </li>                
                
                <li class="@if(url('admin/tugas') == request()->url() or url('admin/tambahtugas')  == request()->url() or url('admin/message/send') == request()->url()) active @else '' @endif">
                  <a href="{{{URL::to('admin/tugas')}}}"><i class="fa fa-plus-square">                    
                  </i> Kelola Tugas</a>
                </li>

                <li class="@if(url('admin/quiz') == request()->url() or url('admin/tambahquiz')  == request()->url() ) active @else '' @endif">
                  <a href="{{{URL::to('admin/quiz')}}}"><i class="fa fa-plus-square">                    
                  </i> Kelola Quiz</a>
                </li>

                <li class="@if(url('admin/soal_quiz') == request()->url() or url('admin/tambah_soal_quiz')  == request()->url() ) active @else '' @endif">
                  <a href="{{{URL::to('admin/soal_quiz')}}}"><i class="fa fa-plus-square">                    
                  </i> Kelola Soal Quiz</a>
                </li>
                
                  
                  <li class="@if(url('admin/nilai_trainee') == request()->url() ) active @else '' @endif">
                      <a href="{{{URL::to('admin/nilai_trainee')}}}"><i class="fa fa-plus-square">                    
                      </i>Nilai Trainee</a>
                    </li>                 
                  
                  </ul>
                </li>

              </ul>
            </li>

          <!--  <li class="@if(url('admin/test_view') == request()->url()) active @else '' @endif"><a href="{{ url('admin/test_view') }}">
            <i class='fa fa-user-plus'></i> <span>View New</span></a>
           </li>  -->

        </ul><!-- /.sidebar-menu -->        
        </section>
        <!-- /.sidebar -->
      </aside>
