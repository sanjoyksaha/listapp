<template>
<div>
	<div v-if="$gate.isAdmin()">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark">Users</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Users</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-danger card-outline">
							<div class="card-header">
								<h3 class="card-title">All User</h3>

								<div class="card-tools">
									<!-- <div class="input-group input-group-sm" style="width: 150px;">
										<input type="text" name="table_search" class="form-control float-right" placeholder="Search">

										<div class="input-group-append">
											<button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
										</div>
									</div> -->
									<div class="dropdown">
										<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Action
										</button>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item" href="javascript:void(0)"  @click="newModal"><i class="fas fa-user-plus ml-0 mr-2"></i> New User</a>
											<a class="dropdown-item" href="#"><i class="far fa-trash-alt mr-2"></i>Delete All</a>
										</div>
									</div>
								</div>
							</div><!-- /.card-header -->
							<div class="card-body table-responsive p-0">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Email</th>
											<th>Type</th>
											<th>Created At</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(user, index) in users.data" :key="user.id">
											<td>{{++index}}</td>
											<td>{{user.name}}</td>
											<td>{{user.email}}</td>
											<td>{{user.type | capitalize}}</td>
											<td>{{user.created_at | date}}</td>
											<td v-if="user.status == 1" v-bind:style="cursor"><span class="badge badge-success text-dark" @click="inactive(user.id)">Active</span></td>
											<td v-else v-bind:style="cursor"><span class="badge badge-danger text-dark" @click="active(user.id)">Inactive</span></td>
											<td>
												<button class="btn btn-outline-info btn-sm" @click="editModal(user)"><i class="fas fa-edit"></i></button>
												<button class="btn btn-outline-danger btn-sm" @click="deleteUser(user.id)"><i class="far fa-trash-alt"></i></button>
											</td>
										</tr>
									</tbody>
								</table>
							</div><!-- /.card-body -->
							<div class="card-footer">
								<pagination :data="users" @pagination-change-page="getResults">
									<span slot="prev-nav">&lt; Previous</span>
									<span slot="next-nav">Next &gt;</span>
								</pagination>
							</div>
						</div><!-- /.card -->
					</div><!-- /.col-md-6 -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>

		<!-- modal -->
		<div class="modal fade bd-example-modal-lg" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle" v-html="editMode ? 'Update User' : 'Add New User' "></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form @submit.prevent="editMode ? updateUser() : createUser()">
					<div class="modal-body">
						<div class="form-group">
							<label for="name">Name</label>
							<input v-model="form.name" type="text" class="form-control" id="name" name="name" placeholder="Enter name" autocomplete="off" :class="{ 'is-invalid': form.errors.has('name') }">
							<has-error :form="form" field="name"></has-error>
							
						</div>
						<div class="form-group">
							<label for="eamil">Email address</label>
							<input v-model="form.email" type="text" class="form-control" id="eamil" name="email" placeholder="Enter email" autocomplete="off" :class="{ 'is-invalid': form.errors.has('email') }">
							<has-error :form="form" field="email"></has-error>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input v-model="form.password" type="password" class="form-control" id="password"  name="password" placeholder="Password" autocomplete="off" :class="{ 'is-invalid': form.errors.has('password') }">
							<has-error :form="form" field="password"></has-error>
						</div>
						<div class="form-group">
							<label for="type">Type</label>
							<select v-model="form.type" name="type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
								<option value="">Select One</option>
								<option value="admin">Admin</option>
								<option value="user">User</option>
							</select>
							<has-error :form="form" field="type"></has-error>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" :class="editMode ? 'btn btn-danger' : 'btn btn-success'" v-html="editMode ? 'Update' : 'Add' "></button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div v-if="!$gate.isAdmin()">
		<not-found></not-found>
	</div>
</div>

</template>

<script>
    export default {
		data() {
			return {
				users: {},
				Active: {color:'green'},
				Inactive: {color:'red'},
				cursor: {cursor:'pointer'},
				form: new Form({
					id: '',
					name: '',
					email: '',
					password: '',
					//password_confirmation: '',
					type: '',
					bio: '',
					image: '',
					status: '',
				}),
				errors: {},
				editMode: false,
			}
		},

		created() {
			this.loadUsers();
			this.listen();
		},

		methods: {
		
			newModal(){
				this.form.reset();
				this.editMode = false;
				$("#addNew").modal('show');
			},

			createUser() {
				this.$Progress.start();
				this.form.post('/api/user')
					.then(res => { 
						this.$Progress.finish();
						this.form.reset();
						$("#addNew").modal('hide');
						EventBus.$emit('load');
						toastr.success(res.data.message);
					})
					.catch(error => this.errors = error.response.data.errors)
			},

			getResults(page = 1) {
				axios.get('/api/user?page=' + page)
					.then(response => {
						this.users = response.data;
					});
			},

			loadUsers() {
				if(this.$gate.isAdmin()){
					// this.$router.push('/dashboard');
				// } else {
					this.$Progress.start()
					axios.get('/api/user')
						.then(res => {
							this.users = res.data;
							this.$Progress.finish()
						})
						.catch(error => console.log(error))
				}
			},

			listen() {
				EventBus.$on('load', ()=>{
                    this.loadUsers();
				})
			},

			
			editModal(user){
				$("#addNew").modal('show');
				this.editMode = true;
				this.form.clear();
				this.form.fill(user);
			},

			updateUser() {
				this.form.patch(`/api/user/${this.form.id}`)
					.then(res =>{
						EventBus.$emit('load');
						$("#addNew").modal('hide');
						toastr.success(res.data.message);
					})
			},

			deleteUser(id) {
				Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/api/user/${id}`)
                        .then((response)=>{
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.data.message,
                                icon: 'success'
							})
							EventBus.$emit('load')
                        })
                        .catch(()=>{
                            Swal.fire({
								title: 'Error',
								text: 'Something Went Wrong',
								icon: 'error',
								timer: 1500,
								showConfirmButton: false
                        	})
                        })
                    }else{
                        Swal.fire({
                            title: 'Cancel',
                            text: 'Your File is safe',
                            icon: 'info',
                            timer: 1500,
                            showConfirmButton: false
                        })
                    }
                })
			},

			active(id) {
				axios.post(`/api/user/active/${id}`)
					.then((res) =>{
						toastr.success(res.data.message);
						EventBus.$emit('load')
					})
			},

			inactive(id) {
				axios.post(`/api/user/inactive/${id}`)
					.then((res) =>{
						toastr.success(res.data.message);
						EventBus.$emit('load')
					})
			},
		}
    }
</script>
