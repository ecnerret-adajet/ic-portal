<template>
<div>

     <div class="card  card-tasks">
            <div class="card-header ">
                <button class="btn btn-fill btn-secondary btn-sm float-right" data-toggle="modal" data-target="#newPermission">
                    Add Permission
                </button>
                <h4 class="card-title">Permissions</h4>
                <p class="card-category">Assigned Permission to role</p>
            </div>
            <div class="card-body">

            <div div class="row" v-if="role">
                <div class="col"  v-for="(x, p) in Math.ceil(permissions.length/10)" :key="p">
                    <div class="column-items mb-3" v-for="(perm, pe) in permissions.slice((x -1) * 10, x *10)" :key="pe">
                        <label class="switch mb-0">
                            <input type="checkbox" :checked="rolePermissions(perm.id)" @click="syncOrDetach(perm.id)">
                            <span class="slider round"></span>
                        </label>
                        <span class="ml-3">{{ perm.name }}</span>
                    </div>
                </div>
            </div>

            </div>
        </div>

    <!-- Add New Permission Modal -->
        <div class="modal fade" id="newPermission" tabindex="-1" role="dialog" aria-labelledby="newPermissionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPermissionLabel">Add New Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">



                <div class="form-group" :class="{ ' has-danger' : errors.name }">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" :class="{ 'is-invalid' : errors.name }" v-model="name" placeholder="Enter Name">
                    <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.slug }">
                    <label>Slug</label>
                    <input type="text" class="form-control" id="slug" :class="{ 'is-invalid' : errors.slug }" v-model="slug" placeholder="Enter Email">
                     <div v-if="errors.slug" class="invalid-feedback">{{ errors.slug[0] }}</div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea rows="4" class="form-control" id="description" v-model="description" placeholder="Enter Description">
                    </textarea>
                </div>

                <div class="alert alert-warning" role="alert">
                    This permission will be add to selected role automatically
                </div>

            </div>
            <div class="modal-footer">
                <div class="row w-100 text-right ml-3">
                    <div class="col">
                        <button type="button" class="btn btn-secondary btn-fill" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-fill" :disabled="validateFields" @click.prevent="storePermission">Submit</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>

</div>
</template>
<script>

import Toasted from 'vue-toasted';
Vue.use(Toasted)

export default {

     props: {
        role: {
            type: Object
        }
    },

    data()  {
        return {
            loading: false,
            permissions: [],
            name: '',
            slug: '',
            description: '',
            attach: '',
            detach: '',
            detachPermissions: [],
            errors: []
        }
    },

    created() {
        this.getPermissions()
    },

    methods: {
        getPermissions() {
            this.loading = true
            axios.get(`/getPermissions`)
            .then(response => {
                this.permissions = response.data
                this.loading = true
            })
        },

        resetFields() {
            this.name = '';
            this.slug = '',
            this.description = '';
        },

         storePermission() {
            axios.post('/storePermission', {
                name: this.name,
                slug: this.slug,
                description: this.description,
                role_list: this.role.id
            })
            .then(response => {
                this.permissions.push(response.data)
                this.role.permissions.push(response.data)
                this.getCurrentPerm.push(response.data.id)
                //trigger close modal on success submission
                $('#newPermission').modal('hide')
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

        rolePermissions(perm) {
            var findRole = this.role.permissions; // container
            return findRole.some(x => x.id == perm); // return boolean if find from container
        },

        updatePermission(perm) {
            axios.patch(`/attachOrDetach/${this.role.id}`, {
                dettached_id : this.detach,
                attached_id:  this.attach
            })
            .then(response => {
                Vue.toasted.show("Updated Successfully!", {
                    theme: "primary",
                    position: "bottom-right",
                    duration : 5000
                });
            });
        },

         syncOrDetach(perm) {
                if(this.getCurrentPerm.indexOf(perm) > -1) {
                    this.detach = perm
                    this.updatePermission(perm)
                    this.getCurrentPerm.splice(this.getCurrentPerm.indexOf(perm), 1)
                } else {
                    this.attach = perm
                    this.updatePermission(perm)
                    this.getCurrentPerm.push(perm)
                }
                return this.getCurrentPerm;
        },
    },

    computed: {

        validateFields() {
            return this.name == '' || this.slug == '' || this.description == '';
        },

        getCurrentPerm() {
            if(this.role.permissions) {
                return this.role.permissions.map(x => x.id);
            }
        }
    }
}
</script>

<style scoped>
    .column-items {
        display: flex;
        align-items: center;
    }
</style>

