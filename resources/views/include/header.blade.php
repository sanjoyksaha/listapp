<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
		</li>
    </ul>

    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3"> --}}
		{{-- <div class="input-group input-group-sm ml-3 w-25">
			<input class="form-control form-control-navbar" v-model="search" v-on:keyup="searchIt" type="search" placeholder="Search" aria-label="Search">
			<div class="input-group-append">
				<button class="btn btn-navbar" v-on:click="searchIt">
					<i class="fas fa-search"></i>
				</button>
			</div>
		</div> --}}
    {{-- </form> --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
		<!-- Notifications Dropdown Menu -->
		<li class="nav-item dropdown">
        
			<a class="nav-link" data-toggle="dropdown" href="#">
				<img src="{{asset('img/profile/'.Auth::user()->image)}}" class="img-circle elevation-3 d-inline" alt="User Image" style="width:30px; height:30px; margin-top:-8px;">
				<p class="lead d-inline">{{Auth::user()->name}}</p> 
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<router-link to="/profile" class="dropdown-item">
					<i class="fas fa-user mr-2 text-danger"></i> <span class="text-danger">Profile</span>
				</router-link>
			</div>
      	</li>
    </ul>
</nav>
<!-- /.navbar -->