<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Event's</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Event's</li>
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
                        <hr>
                        <div v-for="event in events" :key="event.id">
                            <p class="lead d-inline"><span class="text-primary font-weight-bold">{{event.age}}</span> Anniversary Of</p>
                            <p class="lead d-inline text-primary font-weight-bold"><router-link :to="`/company/${event.id}`">{{event.name}}</router-link></p>
                            <p>{{event.established_at | date}}</p>
                            
                        </div>
                    </div><!-- /.col-md-6 -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
</template>

<script>
export default {
    name: "Event",

    created() {
        this.$store.dispatch("allEvent")
    },

    computed: {
        events(){
            return this.$store.getters.getEvents;
        },
    }

}
</script>