<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Company</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Company</li>
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
                            <h3 class="card-title">Edit Company</h3>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" @submit.prevent="editCompany()">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" v-model="form.name" id="name" class="form-control" placeholder="Company Name" autocomplete="off" :class="{ 'is-invalid': form.errors.has('name') }">
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="category" class="col-sm-2 col-form-label">Category <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <select name="category_id" id="category" class="form-control" v-model="form.category_id" :class="{ 'is-invalid': form.errors.has('category_id') }">
                                            <option value="">Select One</option>
                                            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                        </select>
                                        <has-error :form="form" field="category_id"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="established_at" class="col-sm-2 col-form-label">Established At</label>
                                    <div class="col-sm-10">
                                        <input type="date" v-model="form.established_at" id="established_at" class="form-control" placeholder="Company Email" :class="{ 'is-invalid': form.errors.has('established_at') }">
                                        <has-error :form="form" field="established_at"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" v-model="form.email" id="email" class="form-control" placeholder="Company Email" :class="{ 'is-invalid': form.errors.has('email') }">
                                        <has-error :form="form" field="email"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="web" class="col-sm-2 col-form-label">Web Address</label>
                                    <div class="col-sm-10">
                                        <input type="url" v-model="form.website" id="web" class="form-control" placeholder="Company Website Example:-http://www.company.xyz" :class="{ 'is-invalid': form.errors.has('website') }">
                                        <!-- <has-error :form="form" field="website"></has-error> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label">Head Office Address</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" v-model="form.address" id="address" placeholder="Head Office Address" :class="{ 'is-invalid': form.errors.has('address') }"></textarea>
                                        <has-error :form="form" field="address"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="total" class="col-sm-2 col-form-label">Number of Office</label>
                                    <div class="col-sm-10">
                                        <input type="number" v-model="form.total_office" id="total" class="form-control" placeholder="Number Of Office" :class="{ 'is-invalid': form.errors.has('total_office') }">
                                        <has-error :form="form" field="total_office"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label">Details</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" v-model="form.details" id="details" placeholder="Details"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="logo" class="col-sm-2 col-form-label">Logo</label>
                                    <div class="col-sm-10">
                                        <input type="file" @change="changePhoto" id="logo" class="form-control">
                                        <img :src="imageLink()" alt="" width="120" height="90">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <!-- <router-link :to="`/company/${this.$route.params.id}`" class="btn btn-primary">Back</router-link> -->
                                        <button type="button" @click="back()" class="btn btn-primary">Back</button>
                                        <button type="submit" class="btn btn-danger">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "Details",

    data() {
        return {
            form: new Form({
                id: '',
                name: '',
                category_id: '',
                established_at: '',
                email: '',
                website: '',
                address: '',
                total_office: '',
                logo: '',
                details: '',
            }),

            errors: {},
        }
    },

    created() {
        this.$store.dispatch("allCategory");

        axios.get(`/api/company/${this.$route.params.id}`)
            .then((response) => {
                this.form.fill(response.data)
            })
    },

    computed: {
        categories() {
            return this.$store.getters.getCategories;
        }
    },

    methods: {
        changePhoto(e) {
            let file = e.target.files[0];
            let reader = new FileReader();

            let limit = 1020 * 1024 * 1;
            if(file['size'] > limit) {
                toastr.error('Image should not be exceed 1 MB');
                return false;
            }
            reader.onload = (e)=> {
                this.form.logo = e.target.result;
            }
            reader.readAsDataURL(file);
        },

        imageLink() {
            let logo = this.form.logo;
            if(logo.length > 100) {
                return logo;
            } else {
                return `/img/company/${this.form.logo}`;
            }
            
        },

        back() {
            this.$router.push(`/company/${this.form.id}`);
        },

        editCompany() {
            this.form.patch(`/api/company/${this.form.id}`)
                .then(res =>{
                    this.$router.push(`/company/${this.form.id}`);
                    toastr.success(res.data.success);
                })
                .catch(() => toastr.error("Something went wrong"))
        }

    }

}
</script>