<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Details Of Company</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Company Details</li>
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
                                <router-link to="/company-lists"><i class="fas fa-angle-left mr-2"></i>Back</router-link>

                                <div class="card-tools">
                                    <button class="btn btn-outline-primary btn-sm" @click="printDiv('details')"><i class="fas fa-print mr-2"></i>Print</button>
                                    <router-link :to="`/company/${company.id}/edit`" class="btn btn-outline-success btn-sm"><i class="fas fa-edit mr-2"></i>Edit</router-link>
                                    <button class="btn btn-outline-danger btn-sm" @click="deleteCompany(company.id)"><i class="far fa-trash-alt mr-2"></i>Delete</button>
                                </div>
                            </div>
                            <div class="card-body col-md-12" id="details">
                                <img :src="`/img/company/${company.logo}`" alt="" height="50" width="50" class="img-circle elevation-2 mr-3"><span class="font-weight-bold text-primary lead justify-content">{{company.name}}</span>
                                <div>
                                    <hr>
                                    <p class="lead">Email</p>
                                    <p class="text-primary text-bold">{{company.email}}</p>
                                </div>
                                <div v-if="company.website != null">
                                    <hr>
                                    <p class="lead">Website</p>
                                    <p class="text-primary text-bold">{{company.website}}</p>
                                </div>
                                <div>
                                    <hr>
                                    <p class="lead">Category</p>
                                    <p class="text-primary text-bold">{{company.category.name}}</p>
                                </div>
                                <div>
                                    <hr>
                                    <p class="lead">Estalished At</p>
                                    <p class="text-primary text-bold">{{company.established_at | date}}</p>
                                </div>
                                <div>
                                    <hr>
                                    <p class="lead">Address</p>
                                    <p class="text-primary text-bold">{{company.address}}</p>
                                </div>
                                <div>
                                    <hr>
                                    <p class="lead">Number Of Office</p>
                                    <p class="text-primary text-bold">{{company.total_office}}</p>
                                </div>
                                <div v-if="company.details != null">
                                    <hr>
                                    <p class="lead">Details</p>
                                    <p class="text-primary text-bold">{{company.details}}</p>
                                </div>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->
                    </div><!-- /.col-md-6 -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
</template>
<script>
export default {
    name: "Details",

    created() {
        this.$store.dispatch("companyById", this.$route.params.id)
    },

    computed: {
        company(){
            return this.$store.getters.getCompanyById
        },
    },

    methods: {
        deleteCompany(id) {
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
                axios.delete(`/api/company/${id}`)
                    .then((response)=>{
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.data.success,
                            icon: 'success'
                        })
                        this.$router.push('/company-lists')
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

        printDiv(divName) {
            const printContents = document.getElementById(divName).innerHTML;
            const originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            document.body.style.marginTop="10px";
            window.print();
            document.body.innerHTML = originalContents;
	    }
    }

}
</script>