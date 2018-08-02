<template>
<div>


    <div class="row">
        <div class="col">
            <div class="card">
                <div class="header px-4">
                    <h4 class="title mb-0">Provider
                        <button class="btn btn-secondary btn-fill float-right" data-toggle="modal" data-target="#newCompany">
                            Add Provider
                        </button>
                    </h4>
                    <p class="category text-muted">Independent Provider</p>

                    <div class="row mb-2">
                        <div class="col float-left">
                            <div class="form-group w-100">
                                <input type="text" class="form-control" placeholder="Search by name" v-model="search">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end header -->
                <div class="content table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Members</th>
                                <th>Created Date</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(company, c) in filteredQueues" :key="c">
                                <td>{{ company.name }}</td>
                                <td>{{ compayLabors(company.id) }}</td>
                                <td>{{ moment(company.created_at) }}</td>
                                <td>
                                    <a class="btn btn-fill btn-primary" :href="'companies/' + company.id">
                                        Visit
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="card-body pb-0">

                        <div class="bg-light row mb-3"  v-if="filteredQueues.length == 0 && !loading">
                            <div class="col text-center">
                                <h3 class="mt-3 p-3 font-weight-light text-muted text-uppercase">Nothing found</h3>
                            </div>
                        </div>

                         <div v-if="loading" class="row p-3">
                            <div class="col">
                                <content-placeholders style="border: 0 ! important;" :rounded="true">
                                    <content-placeholders-heading :img="true" />
                                    <content-placeholders-text :lines="1" />
                                    <hr/>
                                    <content-placeholders-heading :img="true" />
                                    <content-placeholders-text :lines="1" />
                                    <!-- <content-placeholders-text :lines="3" /> -->
                                </content-placeholders>
                            </div>
                        </div>

                         <div class="row mb-3">
                            <div class="col-6">
                                <button :disabled="!showPreviousLink()" class="btn btn-default btn-sm btn-fill" v-on:click="setPage(currentPage - 1)"> Previous </button>
                                    <span class="text-dark">Page {{ currentPage + 1 }} of {{ totalPages }}</span>
                                <button :disabled="!showNextLink()" class="btn btn-default btn-sm btn-fill" v-on:click="setPage(currentPage + 1)"> Next </button>
                            </div>
                            <div class="col-6 text-right">
                                <span>{{ companies.length }} Labor(s)</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->


    <!-- Add New Company Modal -->
        <div class="modal fade" id="newCompany" tabindex="-1" role="dialog" aria-labelledby="newCompanyLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCompanyLabel">Add New Provider</h5>
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

            </div>
            <div class="modal-footer">
                <div class="row w-100 text-right ml-3">
                    <div class="col">
                        <button type="button" class="btn btn-secondary btn-fill" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-fill" :disabled="validateFields" @click.prevent="storeCompany">Submit</button>
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
import moment from 'moment';
import VueContentPlaceholders from 'vue-content-placeholders';

Vue.use(Toasted)

export default {

    data() {
        return {
            loading: false,
            companies: [],
            labors: [],
            name: '',
            search: '',
            currentPage: 0,
            itemsPerPage: 10,
            errors: []
        }
    },

    created() {
        this.getCompanies()
        this.getLabors()
    },

    methods: {

        getLabors() {
            axios.get('/getLabors')
            .then(response => this.labors = response.data).length;
        },

        getCompanies() {
            axios.get('/getCompanies')
            .then(response => this.companies = response.data);
        },

        storeCompany() {
            axios.post('/companies', {
                name : this.name
            })
            .then(response => {
                this.companies.push(response.data)
                //trigger close modal on success submission
                $('#newCompany').modal('hide')
                this.name = ''
            })
            .catch(error => {
                if(error.response.status == 422) {
                    this.errors = error.response.data.errors
                }
            })
        },

        compayLabors(company) {
            return this.labors.filter(labor => labor.company_id == company).length;
        },

        moment(date) {
            return moment(date).format('YYYY-MM-DD');
        },

        setPage(pageNumber) {
            this.currentPage = pageNumber;
        },

        resetStartRow() {
            this.currentPage = 0;
        },

        showPreviousLink() {
            return this.currentPage == 0 ? false : true;
        },

        showNextLink() {
            return this.currentPage == (this.totalPages - 1) ? false : true;
        }
    },

    computed: {

        validateFields() {
            return this.name == '';
        },

        filteredEntries() {
            return this.companies.filter(item => {
                return item.name.toLowerCase().includes(this.search.toLowerCase());
            })
        },

        totalPages() {
            return Math.ceil(this.filteredEntries.length / this.itemsPerPage)
        },

        filteredQueues() {
            var index = this.currentPage * this.itemsPerPage;
            var queues_array = this.filteredEntries.slice(index, index + this.itemsPerPage);

            if(this.currentPage >= this.totalPages) {
                this.currentPage = this.totalPages - 1
            }

            if(this.currentPage == -1) {
                this.currentPage = 0;
            }

            return queues_array;
        },

    }

}
</script>
