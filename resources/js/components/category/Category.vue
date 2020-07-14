<template>

<div>
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Categories</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Categories</li>
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
							<h3 class="card-title">All Category</h3>

							<div class="card-tools">
								<div class="dropdown">
									<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Action
									</button>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
										<a class="dropdown-item" href="javascript:void(0)"  @click="modal"><i class="fas fa-plus ml-0 mr-2"></i>Add Category</a>
										<a class="dropdown-item" href="javascript:void(0)" @click="deleteSelected"><i class="far fa-trash-alt mr-2"></i>Delete All</a>
									</div>
								</div>
							</div>
						</div><!-- /.card-header -->
						<div class="card-body table-responsive p-0">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th><input type="checkbox" v-model="select_all" @click="selectAll"></th>
										<th>#</th>
										<th>Name</th>
										<th>Slug</th>
										<th>Created At</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(category, i) in categories" :key="category.id">
										<td><input type="checkbox" v-model="categoryItem" :value="category.id"></td>
										<td>{{++i}}</td>
										<td>{{category.name}}</td>
										<td>{{category.slug}}</td>
										<td>{{category.created_at | date}}</td>
										<td>
											<button class="btn btn-outline-info btn-sm" @click="editCategory(category)"><i class="fas fa-edit"></i></button>
											<button class="btn btn-outline-danger btn-sm" @click="deleteCategory(category.id)"><i class="far fa-trash-alt"></i></button>
										</td>
									</tr>
								</tbody>
							</table>
						</div><!-- /.card-body -->
						<!-- <div class="card-footer">
							<pagination :data="all"  @pagination-change-page="getResults">
								<span slot="prev-nav">&lt; Previous</span>
								<span slot="next-nav">Next &gt;</span>
							</pagination>
						</div> -->
					</div><!-- /.card -->
				</div><!-- /.col-md-6 -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

	<!-- modal -->
	<div class="modal fade bd-example-modal-lg" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle" v-html="editMode ? 'Update Category' : 'Add New Category'"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="submit">
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Name</label>
						<input v-model="form.name" type="text" class="form-control" id="name" name="name" placeholder="Enter name" autocomplete="off" :class="{ 'is-invalid': form.errors.has('name') }">
						<has-error :form="form" field="name"></has-error>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" :class="editMode ? 'btn btn-danger' : 'btn btn-success'" v-html="editMode ? 'Update' : 'Add'"></button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

</template>

<script>
    export default {

		data() {
			return {
				form: new Form({
					id: '',
					name: '',
				}),
				errors: {},
				editMode: false,
				// all: {},
				categoryItem: [],
                select_all:false,
			}
		},

		created() {
			this.load();
			this.listen();
		},

		computed: {
			categories() {
				return this.$store.getters.getCategories;
			}
		},

		methods: {
			load(){
				this.$store.dispatch("allCategory")
			},

			submit() {
				this.editMode ? this.updateCategory() : this.createCategory()
			},

			modal(){
				this.form.reset();
				this.editMode = false;
				$("#addNew").modal('show');
			},

			createCategory() {
				this.form.post('/api/category')
					.then(res => {
						this.form.reset();
						$("#addNew").modal('hide');
						EventBus.$emit('load');
						toastr.success(res.data.success);
					})
					.catch(error => this.errors = error.response.data.errors)
			},

			editCategory(category){
				$("#addNew").modal('show');
				this.editMode = true;
				this.form.clear();
				this.form.fill(category);
			},

			updateCategory() {
				this.form.patch(`/api/category/${this.form.id}`)
					.then(res => {
						$("#addNew").modal('hide');
						EventBus.$emit('load');
						toastr.success(res.data.success);
					})
					.catch(error => this.errors = error.response.data.errors)
			},

			deleteCategory(id) {
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
                        axios.delete(`/api/category/${id}`)
                        .then((response)=>{
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.data.sucsess,
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

			// getResults(page = 1) {
			// 	axios.get('/api/category?page=' + page)
			// 		.then(res => {
			// 			this.all = res.data;
			// 		});
			// },

			listen() {
				EventBus.$on('load', ()=>{
					this.load();
				})
			},

			selectAll(){
				if(this.select_all == false) {
                    this.select_all = true;
                    for(var category in this.categories) {
						this.categoryItem.push(this.categories[category].id);
						
					}
                } else {
                    this.select_all = false;
                    this.categoryItem = [];
				}
			},

			deleteSelected() {
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
                        axios.delete('/api/category/deleteSelected/'+this.categoryItem)
                        .then((response)=>{
                            EventBus.$emit('load')
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.data.success,
                                icon: 'success'
                            })
                            this.categoryItem = [];
                        })
                        .catch(()=>{
                            Swal.fire({
                                text: 'Please Select An Item.',
                                icon: 'question',
                                timer: 1500,
                                showConfirmButton: false
                            })
                        })
                    }else{
                        Swal.fire({
                            title: 'Cancel',
                            text: 'Your File Is Safe.',
                            icon: 'info',
                            timer: 1500,
                            showConfirmButton: false
                        })
                    }
                })
            },
		}
    }
</script>
