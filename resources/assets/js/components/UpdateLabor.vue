<template>
    <div>

        <a href="javascript:void(0);" :class="{ disabled : labor.status == 0 }" class="btn btn-secondary ml-3 btn-sm btn-fill"
                                        data-toggle="modal"
                                        :data-target="'#updateLabor-'+labor.id">Update</a>

        <!-- Update Labor Modal -->
        <div class="modal fade" :id="`updateLabor-${labor.id}`" tabindex="-1" role="dialog" aria-labelledby="updateLaborLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateLaborLabel">Update Member's Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group" :class="{ ' has-danger' : errors.name }">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" :class="{ 'is-invalid' : errors.name }" v-model="labor.name" placeholder="Enter Name">
                    <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row w-100 text-right ml-3">
                    <div class="col">
                        <button type="button" class="btn btn-secondary btn-fill" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-fill" @click="updateLabor">Submit</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    <!-- end update labor modal -->

    </div>
</template>
<script>

import Toasted from 'vue-toasted';
Vue.use(Toasted)

export default {

    props: {
        labor: {
            type: Object
        }
    },

    data() {
        return {
            errors: [],
        }
    },

    methods: {
        updateLabor() {
            axios.patch(`/updateDetails/${this.labor.id}`, {
                name : this.labor.name,
            })
            .then(response => {
                 this.$emit('updateLabor',response.data.name);
                 this.errors = []
                 $('#updateLabor-' + this.labor.id).modal('hide')
                 Vue.toasted.show("Updated Successfully!", {
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
