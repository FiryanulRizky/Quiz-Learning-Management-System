<!-- Terpaksa Ngoding di View -->
<?php 
  $i = Auth::user()->level;
  $idUser = Auth::user()->id_user;                         
  $trainee = \App\Trainee::where('id_user', $idUser)->first(); // detail field trainee yang sedang login.
  $trainer = \App\Trainer::where('id_user', $idUser)->first(); // detail field trainee yang sedang login.
  $foto = 'foto .jpg';
?>
      <header class="main-header">

        <!-- Logo -->
        <a href="{{URL::to('/')}}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>ETC</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>E-Learning PTTC</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu Selamat Datang di E-Learning Software Logistics -->          
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav" >
              <li>
                <a href="#">
                  <!-- <b> Waktu Sekarang : </b>{{ date("d m Y H:i:s ")  }}<br>   -->
                  <!-- <div id="clock">00</div>   -->
                </a>                
              </li>
              
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">                  
                    @if ($i === 11)                     
                      <img src="{{asset('/img/avatar5.png')}}" class="user-image" alt="User Image">                
                    @elseif ($i === 12)
                      <img src="{{URL::to('upload_gambar/'.$trainer->foto_trainer) }}" class="user-image" alt="User Image">
                    @elseif ($i === 13)
                      <img src="{{URL::to('upload_gambar/'.$trainee->foto_trainee) }}" class="user-image" alt="User Image">                    
                    @endif  
                    <span class="hidden-xs"><b>
                        {{ Auth::user()->name  }}
                    </b></span>                
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->                  
                  <li class="user-header">                                                         
                      @if ($i === 11) 
                      <img src="{{asset('/img/avatar5.png')}}" class="img-circle" alt="User Image">
                      @elseif ($i === 12)
                      <img src="{{URL::to('upload_gambar/'.$trainer->foto_trainer) }}" class="img-circle" alt="User Image">
                      @elseif ($i === 13)
                      <img src="{{URL::to('upload_gambar/'.$trainee->foto_trainee) }}" class="img-circle" alt="User Image">
                      @endif
                      <p>
                      <b>Username : </b>{{ Auth::user()->username  }}<br>
                      <b>Otoritas user : </b>Level {{Auth::user()->level}} 
                      <small></small>
                    </p>
                  </li>                 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      @if ($i === 11) 
                        <a href="{{{ URL::to('admin/user/'.Auth::user()->id_user.'/ubahpassword') }}}" class="btn btn-default btn-flat">Ubah Password</a>
                      @elseif ($i === 12)                                              
                        <a href="{{{ URL::to('trainer/trainer/'.$trainer->nik_trainer.'/detail') }}}" class="btn btn-default btn-flat">Profile</a>
                      @elseif ($i === 13)
                        <a href="{{{ URL::to('trainee/trainee/'.$trainee->nik_trainee.'/detail') }}}" class="btn btn-default btn-flat">Profile</a>
                      @endif
                    </div>
                    <div class="pull-right">
                      <a href="{{{URL::to('/logout')}}}" class="btn btn-default btn-flat">Sign Out</a>
                    </div>                                      
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->              
            </ul>
          </div>

        </nav>
      </header>