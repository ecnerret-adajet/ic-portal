<template>
    <div>

        <div v-if="!editing" class="alert alert-success alert-with-icon" data-notify="container">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                <i class="nc-icon nc-simple-remove"></i>
            </button>
            <span data-notify="icon" class="nc-icon nc-bell-55"></span>
            <span data-notify="message">Profile Updated Successfully.</span>
        </div>

     <div class="row">
        <div class="col">
            <div class="card">
                <div class="header px-4 border-bottom">
                    <h4 class="title mb-0">Update Profile
                    </h4>
                    <p class="categoory text-muted">Form</p>
                </div>
                <!-- end header -->

                <div class="content table-responsive">
                     <div class="card-body p-4" v-if="user.length != 0">

                <div class="form-group form-row" :class="{ ' has-danger' : errors.name }">
                   <div class="col">
                    <label>Name</label>
                    <input type="text" class="form-control form-control-lg rounded-0" :disabled="!editing" :class="{ 'is-invalid' : errors.name }"  id="name" v-model="user.name" placeholder="Enter Name">
                    <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                   </div>
                   <div class="col">
                    <label>Email</label>
                    <input type="email" class="form-control form-control-lg rounded-0" :disabled="!editing" :class="{ 'is-invalid' : errors.email }"  id="email" v-model="user.email" placeholder="Enter Email">
                    <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
                   </div>
                </div>

                <div v-if="editing" class="form-group form-row" :class="{ ' has-danger' : errors.password }">
                    <div class="col">
                        <label>Password</label>
                        <input type="password" class="form-control form-control-lg rounded-0" :class="{ 'is-invalid' : errors.password }"  id="password" v-model="user.password" placeholder="Enter Password">
                        <div v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</div>
                    </div>
                    <div class="col">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control form-control-lg rounded-0" :class="{ 'is-invalid' : errors.password_confirmation }"  id="password_confirm" v-model="user.password_confirmation" placeholder="Enter Password">
                        <div v-if="errors.password_confirmation" class="invalid-feedback">{{ errors.password_confirmation[0] }}</div>
                    </div>
                </div>


                <div class="row">
                    <div class="col text-right">
                        <button class="btn btn-primary btn-fill rounded p-3" v-if="editing" @click="profileUpdate" style="width: 150px">
                            Submit
                        </button>
                        <button class="btn btn-secondary btn-fill rounded p-3" v-else @click="editing = true" style="width: 150px">
                            Edit
                        </button>
                    </div>
                </div>


                    </div>
                </div>


            </div>
            <!-- end card -->
        </div>
    </div>
    <!-- end row -->

    </div>
</template>
<script>

import Toasted from 'vue-toasted';
Vue.use(Toasted)

export default {

    props: {
        user: {
            type: Object
        }
    },

    data() {
        return {
            editing: true,
            errors: []
        }
    },

    methods: {
        profileUpdate() {
            axios.patch(`/profile/update/${this.user.id}`, {
                name : this.user.name,
                email : this.user.email,
                password : this.user.password,
                password_confirmation: this.user.password_confirmation,
            })
            .then(response => {
                this.editing = false
                Vue.toasted.show("Successfully Updated!", {
                    theme: "primary",
                    position: "bottom-right",
                    duration : 5000
                });
            })
            .catch(error => {
                if(error.response.status == 422) {
                    this.errors = error.response.data.errors
                }
            })
        }
    }


}
</script>
