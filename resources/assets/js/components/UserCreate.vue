<template>
    <div>

        <div class="row">
        <div class="col">
            <div class="card">
                <div class="header px-4 border-bottom">
                    <h4 class="title mb-0">Register User
                    </h4>
                    <p class="categoory text-muted">Form</p>
                </div>
                <!-- end header -->

                <div class="content table-responsive">
                     <div class="card-body p-4">

                <div class="form-group form-row" :class="{ ' has-danger' : errors.role_list }">
                    <div class="col">
                        <label>Role</label>
                        <select class="form-control form-control-lg rounded-0" :class="{ 'is-invalid' : errors.role_list }" v-model="user.role">
                            <option selected value="">Select Role</option>
                            <option v-for="(role, r) in roles" :key="r" :value="role.id">{{ role.name }}</option>
                        </select>
                        <div v-if="errors.role_list" class="invalid-feedback">{{ errors.role_list[0] }}</div>
                    </div>
                    <div class="col">
                        <label>Company</label>
                        <select class="form-control form-control-lg rounded-0" :class="{ 'is-invalid' : errors.company }" v-model="user.company">
                            <option selected value="">Select Company</option>
                            <option v-for="(company, c) in companies" :key="c" :value="company.id">{{ company.name }}</option>
                        </select>
                        <div v-if="errors.company" class="invalid-feedback">{{ errors.company[0] }}</div>
                    </div>
                </div>

                <div class="form-group form-row" :class="{ ' has-danger' : errors.name }">
                   <div class="col">
                    <label>Name</label>
                    <input type="text" class="form-control form-control-lg rounded-0" :class="{ 'is-invalid' : errors.name }"  id="name" v-model="user.name" placeholder="Enter Name">
                    <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                   </div>
                   <div class="col">
                    <label>Email</label>
                    <input type="email" class="form-control form-control-lg rounded-0" :class="{ 'is-invalid' : errors.email }"  id="name" v-model="user.email" placeholder="Enter Email">
                    <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
                   </div>
                </div>

                <div class="form-group form-row" :class="{ ' has-danger' : errors.email }">
                    <div class="col">
                    <label>Email</label>
                    <input type="email" class="form-control form-control-lg rounded-0" :class="{ 'is-invalid' : errors.email }"  id="name" v-model="user.email" placeholder="Enter Name">
                    <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
                    </div>
                </div>

                <div class="form-group form-row" :class="{ ' has-danger' : errors.passowrd }">
                    <div class="col">
                    <label>Password</label>
                    <input type="text" class="form-control form-control-lg rounded-0" :class="{ 'is-invalid' : errors.passowrd }"  id="name" v-model="user.password" placeholder="Enter Password">
                    <div v-if="errors.passowrd" class="invalid-feedback">{{ errors.passowrd[0] }}</div>
                    </div>
                </div>


                <div class="row">
                    <div class="col text-right">
                        <button class="btn btn-primary btn-fill rounded p-3" style="width: 150px">
                            Submit
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
export default {

    data() {
        return {
            roles: [],
            companies: [],
            errors: [],
            user: {
                role: '',
                company: '',
                name: '',
                email: '',
                password: '',
                confirmPassword: ''
            }
        }
    },

    created() {
        this.getRoles()
        this.getCompanies()
    },

    methods: {

        getRoles() {
            axios.get('/getRoles')
            .then(response => this.roles = response.data);
        },

        getCompanies() {
            axios.get('/getCompanies')
            .then(response => this.companies = response.data)
        },

        storeUser() {
            axios.post('/users', {
                name : this.user.name,
                password : this.user.password,
                email : this.user.email,
                role_list : this.user.role,
                company_list : this.user.company
            })
            .then(response => {
                window.location = response.data.redirect;
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
