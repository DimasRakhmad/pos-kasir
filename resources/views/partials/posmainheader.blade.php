<!-- Main Header -->
<header class="main-header">

    

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        
        <div class="nav navbar-left">
            <ul class="nav navbar-nav">
                
            </ul>
        </div>
        <!-- Navbar Right Menu -->
       <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                	<a href="{{url('/pilih')}}"><i class="fa fa-list"></i><span>Main Menu</span></a>
                </li> 
               	<li>
               		<a href="{{url('/piutang-karyawan-pos')}}" ><i class="fa fa-list"></i><span>List Piutang</span></a>
               	</li>
               	<li>
               		<a href="{{url('auth/logout')}}" ><i class="fa fa-sign-out"></i><span>Logout</span></a>
               	</li>
            </ul>
        </div>
    </nav>
</header>