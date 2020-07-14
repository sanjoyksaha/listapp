<template>
    <div class="tab-pane" id="settings">
        <form class="form-horizontal">
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" v-model="form.name" class="form-control" placeholder="Name" autocomplete="off" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" v-model="form.email" class="form-control" placeholder="Email" :class="{ 'is-invalid': form.errors.has('email') }">
                <has-error :form="form" field="email"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label">Password (Leave empty if not changing)</label>
            <div class="col-sm-10">
                <input type="text" v-model="form.password" class="form-control" placeholder="Password" :class="{ 'is-invalid': form.errors.has('password') }">
                <has-error :form="form" field="password"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="bio" class="col-sm-2 col-form-label">Bio</label>
            <div class="col-sm-10">
                <textarea class="form-control" v-model="form.bio" placeholder="Bio"></textarea>
            </div>
        </div>
        <div class="form-group row" v-if="$gate.isAdmin()">
            <label for="type" class="col-sm-2 col-form-label">Type</label>
            <div class="col-sm-10">
                <select v-model="form.type" name="type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                    <option value="">Select One</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <has-error :form="form" field="type"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="image" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
                <input type="file" @change="changePhoto" class="form-control">
                <img :src="imageLink()" alt="" width="180" height="150">
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
            <button type="submit" class="btn btn-danger" @click.prevent="updateProfile">Update Profile Changes</button>
            </div>
        </div>
        </form>
    </div>
    <!-- /.tab-pane -->
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                id: '',
                name: '',
                email: '',
                password: '',
                type: '',
                bio: '',
                image: '',
                status: '',
            }),
        }
    },

    created() {
        axios.get('/api/profile')
            .then(res => {
                this.form.fill(res.data);
            })
            .catch(errors => console.log(errors.response.data))
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
                    this.form.image = e.target.result; 
                }
                reader.readAsDataURL(file);
        },

        updateProfile() {
            this.$Progress.start();
            if(this.form.password == ''){
                this.form.password = undefined;
            }
            this.form.patch('/api/updateProfile')
                .then(res =>{
                    toastr.success(res.data.message);
                    EventBus.$emit('update');
                    this.$Progress.finish();
                })
                .catch(error => {
                    this.$Progress.fail();
                })
        },

        imageLink() {

            let image = (this.form.image.length > 100) ? this.form.image : "/img/profile/"+ this.form.image ;
            return image;
            
        }, 
    },

}
</script>