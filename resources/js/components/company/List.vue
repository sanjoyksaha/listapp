<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Company's</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Company's</li>
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
                                <h3 class="card-title">All Company</h3>

                                <div class="card-tools">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <router-link to="/create-company" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-plus-square ml-0 mr-2"></i> Add New Company</router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-group input-group-sm w-100 mb-5">
                                    <input class="form-control form-control-navbar" v-model="search" v-on:keyup="searchIt" type="search" placeholder="Search" aria-label="Search">
                                    <!-- <div class="input-group-append">
                                        <button class="btn btn-navbar" v-on:click="searchIt">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div> -->
                                </div>
                                <div v-for="(company) in companies" :key="company.id">
                                    <div class="col-md-12">
                                        <div class="col-md-1 float-left">
                                            <img :src="imageLink(company.logo)" alt="" height="50" width="50" class="img-circle elevation-2 mr-3">
                                        </div>
                                        <div class="col-md-11 float-left justify-content-between">
                                            <router-link :to="`/company/${company.id}`" class="lead m-0 p-0">{{company.name}}</router-link>
                                            <!-- <p class="text-primary">{{company.name}}</p> -->
                                            <p class="text-muted">{{company.email}}</p>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.card -->
                    </div><!-- /.col-md-6 -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
</template>

<script>
// import _ from 'lodash';
    export default {
        name: "List",

        data() {
            return {
                search: '',
            }
        },

        created() {
            this.$store.dispatch("allCompany")
        },

        computed: {
            companies(){
                return this.com = this.$store.getters.getCompanies;
            },
        },

        methods: {
            imageLink(img) {
                return `/img/company/${img}`;
            },

            // searchIt: _.debounce(() => {
            //     this.$store.dispatch("search", this.search);
            // }, 1000)
            searchIt(){
                this.$store.dispatch('search',this.search);
            },
        }

    }
</script>

<style scoped>

</style>
