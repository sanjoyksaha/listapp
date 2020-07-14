<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><span class="text-danger">{{user.name}}</span> Profile</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
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
                        <div class="card card-widget widget-user">
                            <div class="widget-user-header text-white" style="background: url('./img/photo1.png') center center;">
                                <h3 class="widget-user-username text-right" v-if="user.name">{{user.name}}</h3>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle" :src="imageLink(user.image)" alt="User Avatar">
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                        <h5 class="description-header">Email</h5>
                                        <span class="">{{user.email}}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                        <h5 class="description-header">Status</h5>
                                        <span class="" :class="user.status == 1 ? 'text-success' : 'text-danger'" v-html="user.status == 1 ? 'Active' : 'Inactive'"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header">User Type</h5>
                                            <span class="">{{user.type | capitalize}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-danger card-outline">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#bio" data-toggle="tab">Bio</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="bio">
                                        <p class="lead text-justify">{{user.bio ? user.bio : 'You do not added any bio..'}}</p>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <settings></settings>
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>

                    </div><!-- /.col-md-6 -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
</template>

<script>
import Settings from './Settings'
export default {
    components:{
        Settings,
    },

    data() {
        return {
            user: '',
        } 
    },

    created() {    
        this.loadProfiledata();
        this.listen();

    },

    methods: {
        loadProfiledata() {
            axios.get('/api/profile')
            .then(res => {
                this.user = res.data;
            })
            .catch(errors => console.log(errors.response.data))
        },

        listen() {
            EventBus.$on('update', (e) => {
                this.loadProfiledata();
            })
        },

        imageLink(img) {
            return "img/profile/"+ img ;
        }
			
    }
}
</script>