<template>
<div>
        <!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Dashboard</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
    <!-- /.content-header -->
    <div class="content">
      	<div class="container-fluid">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-4 col-sm-6 col-md-4" v-if="$gate.isAdmin()">
							<div class="info-box">
								<span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-shield"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Total Admin</span>
									<span class="info-box-number">
										{{total_admin}}
									</span>
								</div>
								<!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						</div>
						<div class="col-4 col-sm-6 col-md-4" v-if="$gate.isAdmin()">
							<div class="info-box">
								<span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Total User</span>
									<span class="info-box-number">
										{{total_user}}
									</span>
								</div>
								<!-- /.info-box-content -->
							</div>
						<!-- /.info-box -->
						</div>
						<!-- /.col -->
						<div class="col-4 col-sm-6 col-md-4" v-if="$gate.isAdmin()">
							<div class="info-box mb-3">
								<span class="info-box-icon bg-green elevation-1"><i class="fas fa-user-check"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Active User</span>
									<span class="info-box-number">{{active_user}}</span>
								</div>
								<!-- /.info-box-content -->
							</div>
						<!-- /.info-box -->
						</div>
						
						<!-- /.col -->

						<!-- fix for small devices only -->
						<div class="clearfix hidden-md-up"></div>

						<div class="col-4 col-sm-6 col-md-4" v-if="$gate.isAdmin()">
							<div class="info-box mb-3">
								<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-times"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Inactive users</span>
									<span class="info-box-number">{{inactive_user}}</span>
								</div>
							</div>
						</div>
						<!-- /.col -->
						<div class="col-4 col-sm-6 col-md-4">
							<div class="info-box mb-3">
								<span class="info-box-icon bg-primary elevation-1"><i class="fas fa-bars"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Total Category</span>
									<span class="info-box-number">{{total_category}}</span>
								</div>
							</div>
						</div>
						<!-- /.col -->
						<div class="col-4 col-sm-6 col-md-4">
							<div class="info-box mb-3">
								<span class="info-box-icon bg-warning elevation-1"><i class="far fa-address-card"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Total Company</span>
									<span class="info-box-number">{{total_company}}</span>
								</div>
							</div>
						</div>
					</div>
					<!-- /.col -->
				</div>
				<div class="col-md-4">
					<div class="info-box bg-teal">
						<!-- <span class="info-box-icon"><i class="far fa-heart"></i></span> -->

						<div class="info-box-content">
							<span class="info-box-text mb-2"><i class="far fa-heart mr-2 font-weight-bold"></i>Event's of the Month</span>
							<span class="info-box-number ml-2" v-for="event in events" :key="event.id">{{event.age}} Anniversary of <router-link :to='`/company/${event.id}`' class="text-dark">{{event.name}}</router-link></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="card card-danger card-outline">
						<div class="card-header">
							<div class="card-title">
								<h3>New Companies</h3>
							</div>
						</div>
						<!-- <div class="card-body table-responsive p-0">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Email</th>
										<th>Address</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(new_company, i) in new_companies" :key="new_company.id">
										<td>{{++i}}</td>
										<td>{{new_company.name}}</td>
										<td>{{new_company.email}}</td>
										<td>{{new_company.address}}</td>
									</tr>
								</tbody>
							</table>
						</div> -->
						<div v-for="company in new_companies" :key="company.id">
							<div class="col-md-12 mt-2 mb-2">
								<div class="col-md-1 float-left">
									<img :src="imageLink(company.logo)" alt="" height="50" width="50" class="img-circle elevation-2 mr-3">
								</div>
								<div class="col-md-11 justify-content">
									<router-link :to="`/company/${company.id}`" class="lead m-0 p-0">{{company.name}}</router-link>
									<!-- <p class="text-primary">{{company.name}}</p> -->
									<p class="text-muted">{{company.email}}</p>
								</div>
								<hr>
							</div>
						</div>
					</div>
				</div>
			</div>
      	</div><!-- /.container-fluid -->
    </div>
</div>
</template>

<script>
    export default {
		data() {
			return {
				total_admin: '',
				total_user: '',
				active_user: '',
				inactive_user: '',
				total_category: '',
				total_company: '',
				new_companies: '',
				events: '',
			}
		},

        created() {
          axios.get('/api/dashboard')
            .then(res => {
				if(this.$gate.isAdmin()){
					this.total_admin = res.data.total_admin;
					this.total_user = res.data.total_user;
					this.active_user = res.data.active_user;
					this.inactive_user = res.data.inactive_user;
					this.total_category = res.data.total_category;
					this.total_company = res.data.total_company;
					this.new_companies = res.data.new_companies;
					this.events = res.data.events;
				} else {
					this.total_category = res.data.total_category;
					this.total_company = res.data.total_company;
					this.new_companies = res.data.new_companies;
				}
            })
		},
		
		methods: {
            imageLink(img) {
                return `/img/company/${img}`;
            }
        }
    }
</script>
