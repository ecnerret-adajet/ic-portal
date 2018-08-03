<template>
    <div>

        <div class="row">
            <div class="col-md-4">
                <div class="card  card-tasks">
                    <div class="card-header ">
                        <button class="btn btn-fill btn-secondary btn-sm float-right" data-toggle="modal" data-target="#newRole">
                            Add Role
                        </button>
                        <h4 class="card-title">Roles</h4>
                        <p class="card-category">All User roles</p>
                    </div>
                    <div class="card-body">

                        <div class="list-group list-group-flush">
                            <a href="javascript:void(0);" v-for="(role, r) in roles" :key="r"
                                                    @click="selectedRole = role.id"
                                                    class="list-group-item list-group-item-action role-item"
                                                    :class="{ active : role.id == selectedRole }">
                                <span>
                                {{ role.name }}
                                </span>
                                <span class="remove-item">
                                    <i class="nc-icon nc-simple-remove" @click="removeRole(role)"></i>

                                </span>
                            </a>
                        </div>

                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="now-ui-icons loader_refresh spin"></i> Updated 3 minutes ago
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">

                <keep-alive>
                <permissions :role="role" ></permissions>
                </keep-alive>

            </div>
        </div>

         <!-- Add New Role Modal -->
        <div class="modal fade" id="newRole" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group" :class="{ ' has-danger' : errors.name }">
                    <label>Name</label>
                    <input type="text" class="form-control" :class="{ 'is-invalid' : errors.name }"  id="name" v-model="name" placeholder="Enter Name">
                    <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.level }">
                    <label>Level</label>
                    <input type="number" class="form-control" :class="{ 'is-invalid' : errors.level }"  id="slug" v-model="level" placeholder="Enter Email">
                    <div v-if="errors.level" class="invalid-feedback">{{ errors.level[0] }}</div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea rows="4" class="form-control" id="description" v-model="description" placeholder="Enter Description">
                    </textarea>
                </div>

            </div>
            <div class="modal-footer">
                <div class="row w-100 text-right ml-3">
                    <div class="col">
                        <button type="button" class="btn btn-secondary btn-fill" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-fill" :disabled="validateFields" @click.prevent="storeRoles">Submit</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <!-- end add new role modal -->

    </div>
</template>
<script>

import Toasted from 'vue-toasted';
import moment from 'moment';
import VueContentPlaceholders from 'vue-content-placeholders';
import Permissions from './Permissions.vue';

Vue.use(Toasted)

export default {

    components: {
        Permissions
    },

    data() {
       return {
            loading: false,
            selectedRole : 1,
            roles: [],
            name: '',
            description: '',
            level: '',
            errors: [],
        }
    },

    created() {
        this.getRoles()
    },

    watch: {
        role() {
            return this.role
        },
        selectedRole() {
            return this.getRoles()
        },

    },

    methods: {

        resetFields() {
            this.name = '';
            this.level = '',
            this.description = '';
        },


        getRoles() {
            this.loading = true
            axios.get(`/getRoles`)
            .then(response => {
                this.roles = response.data
                this.loading = false
            });
        },

        storeRoles() {
            axios.post('/storeRoles', {
                name: this.name,
                level: this.level,
                description: this.description,
            })
            .then(response => {
                this.roles.push(response.data)
                this.selectedRole = response.data.id
                //trigger close modal on success submission
                $('#newRole').modal('hide')
                this.resetFields()
                Vue.toasted.show("Added Successfully!", {
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

        },

        removeRole(role) {
            axios.delete(`/removeRole/${role.id}`, {
                role: this.role.id
            })
            .then(response => {
                this.roles.splice(this.roles.indexOf(role), 1)
                this.selectedRole = this.roles.slice(-1)[0]['id']
                 Vue.toasted.show("Added Successfully!", {
                    theme: "primary",
                    position: "bottom-right",
                    duration : 5000
                });
            })
            .catch(error => {
                if(error.response.status == 500) {
                    Vue.toasted.show("You cannot delete admin role!", {
                        theme: "primary",
                        position: "bottom-right",
                        duration : 5000
                    });
                }
            })
        },

    },

    computed: {
        validateFields() {
            return this.name == '' || this.level == '' || this.description == '';
        },

        role() {
            return this.roles.find(role => role.id == this.selectedRole);
        },

        getCurrentPerm() {
            if(this.role.permissions) {
                return this.role.permissions.map(x => x.id);
            }
        },

    }

}
</script>
<style lang="scss" scoped>
    .role-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        animation-duration: 0.3s;
    }
    .role-item:hover > .remove-item {
        opacity: 1;
    }
    .remove-item {
        opacity: 0;
        cursor: pointer;
        margin-left: 14px;
        &:hover {
            color: black;
        }
    }
</style>

