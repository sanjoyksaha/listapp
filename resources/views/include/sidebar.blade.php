<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-info elevation-4">

    <a href="javascript:void(0)" class="brand-link">
		<i class="far fa-list-alt ml-3 mr-2"></i>
		<span class="brand-text font-weight-light">ListApp</span>
    </a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<router-link to="/dashboard" class="nav-link">
						<i class="nav-icon fas fa-tv text-danger"></i>
						<p>Dashboard</p>
					</router-link>
				</li>
				<span style="border-bottom: 1px solid #dee2e6; margin:10px 0px 10px 0px;"></span>
				@can('isAdmin')
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class=" nav-icon fas fa-users-cog text-danger"></i>
						<p>User Management
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<router-link to="/users" class="nav-link">
								<i class="nav-icon fas fa-users text-danger"></i>
								<p>Users</p>
							</router-link>
						</li>
					</ul>
				</li>
				<span style="border-bottom: 1px solid #dee2e6; margin:10px 0px 10px 0px;"></span>
				@endcan
				<li class="nav-item">
					<router-link to="/category" class="nav-link">
						<i class="nav-icon fas fa-bars text-danger"></i>
						<p>Category</p>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/company-lists" class="nav-link">
						<i class="nav-icon far fa-address-card text-danger"></i>
						<p>Company's</p>
                    </router-link>
				</li>
				{{-- <li class="nav-item">
					<router-link to="/testing" class="nav-link">
						<i class="nav-icon far fa-address-card text-danger"></i>
						<p>Testing</p>
					</router-link>
				</li> --}}
				<li class="nav-item">
					<router-link to="/events" class="nav-link">
						{{-- <i class="far fa-calendar-alt"></i> --}}
						{{-- <i class="nav-icon fas fa-birthday-cake text-danger"></i> --}}
						<i class="nav-icon fas fa-calendar-week text-danger"></i>
						<p>Events</p>
					</router-link>
				</li>
				<span style="border-bottom: 1px solid #dee2e6; margin:10px 0px 10px 0px;"></span>
				<li class="nav-item">
					<router-link to="/profile" class="nav-link">
						<i class="nav-icon fas fa-user-tie text-danger"></i>
						<p>Profile</p>
					</router-link>
				</li>
				<span style="border-bottom: 1px solid #dee2e6; margin:10px 0px 10px 0px;"></span>
				<li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                        <p>{{ __('Logout') }}</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
