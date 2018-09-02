<template>
    <div>

         <div class="row">
            <div class="col">
                <div class="card">
                    <div class="header pl-4">
                        <h4 class="title mb-0">{{ company.name }}
                           <span v-if="checkPermission('add.member')" class="float-right text-right mr-4">
                               <labor-create @pushToLabor="labors.unshift($event)" :company_id="company_id"></labor-create>
                           </span>
                        </h4>
                        <p class="category text-muted">Independent Provider</p>

                         <div class="row mb-2">
                            <div class="col float-left">
                                <div class="form-group w-100">
                                    <input type="text" class="form-control" placeholder="Search by name" v-model="search">
                                </div>
                            </div>
                            <div class="col text-right mr-4">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-primary btn-primary" :class="{ active : filter == 'all'}"  @click="filter = 'all'">
                                        <input type="checkbox" checked="" autocomplete="off"> All
                                    </label>
                                    <label class="btn btn-outline-primary btn-primary" :class="{ active : filter == 'active'}"  @click="filter = 'active'">
                                        <input type="checkbox" autocomplete="off"> Active
                                    </label>
                                    <label class="btn btn-outline-primary btn-primary" :class="{ active : filter == 'inactive'}"  @click="filter = 'inactive'">
                                        <input type="checkbox" autocomplete="off"> Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                <th v-if="checkPermission('marked.member')" width="5%"></th>
                                <th>Name</th>
                                <th>Provider</th>
                                <th>Tag Id</th>
                                <th>Card #</th>
                                <th>Status</th>
                                <th width="5%">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                        <tr v-for="(labor, l) in filteredQueues" :key="l" v-if="!loading">
                            <td v-if="checkPermission('marked.member')" class="text-center">
                                <label class="switch mt-2">
                                    <input type="checkbox" :checked="labor.status" @click="changeStatus(labor)">
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>{{ labor.name }}</td>
                            <td>{{ labor.company }}</td>
                            <td>{{ labor.labor_code }}</td>
                            <td>{{ labor.card_no }}</td>
                            <td>{{ labor.classfication }}</td>
                            <td>
                                <!-- check if user has a permission to assign a member -->
                                <a v-if="checkPermission('assign.member')" href="javascript:void(0);"  :class="{ disabled : labor.status == 0 }" class="btn btn-primary btn-sm btn-fill"
                                                                data-toggle="modal" @click="getCurrentLabor(labor)"
                                                                :data-target="'#addReliever-'+labor.id">Assign</a>

                                <update-labor v-if="checkPermission('update.member')" @updateLabor="labor.name = $event" :labor="labor"></update-labor>

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
                                <span>{{ labors.length }} Total</span>
                            </div>
                        </div>

                    </div>



                    </div>
                </div>
            </div>
            </div>



         <!-- Add Reliever -->
        <div  v-for="(labor, l) in filteredQueues" :key="l" v-if="!loading"  class="modal fade" :id="'addReliever-'+labor.id" tabindex="-1" role="dialog" aria-labelledby="addReliever" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReliever">Assign Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>From</label>
                    <input type="text" class="form-control" disabled :value="labor.name">
                </div>

                <div class="form-group">
                    <label>To</label>
                    <select class="form-control" v-model="selectedToWorker">
                        <option value="" selected>All Members</option>
                        <option v-for="(labor,i) in filterActiveLabors" :key="i" selected :value="labor.id">{{ labor.name }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>From Date</label>
                    <input type="date" class="form-control" v-model="fromDate">
                </div>

                <div class="form-group">
                    <label>To Date</label>
                    <input type="date" class="form-control" v-model="toDate">
                </div>

                <div class="form-group">
                    <label>Remarks</label>
                    <textarea rows="3" class="form-control" v-model="reasons">
                    </textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" :disabled="allowToSubmit" @click.prevent="storeReliever" data-dismiss="modal">Submit</button>
            </div>
            </div>
        </div>
        </div>
        <!-- End Reliver -->




    </div>
</template>
<script>

import Toasted from 'vue-toasted';
import moment from 'moment';
import VueContentPlaceholders from 'vue-content-placeholders';
import LaborCreate from './LaborCreate.vue'
import UpdateLabor from './UpdateLabor.vue'
import { mapState } from 'vuex';

Vue.use(Toasted)

export default {

    components: {
        LaborCreate,
        UpdateLabor
    },

    props: [
        'company_id'
    ],

    data() {
        return {
            loading: false,
            company: [],
            getLabor: [],
            labors: [],
            date: moment().format('YYYY-MM-DD'),
            selectedFromWorker: '',
            selectedToWorker: '',
            fromDate: '',
            toDate: '',
            reasons: '',
            currentPage: 0,
            itemsPerPage: 10,
            search: '',
            filter: 'all',
        }
    },

    watch: {
        filter() {
            return this.getLabors()
        },
    },

    created() {

        this.getLabors()
        this.getCompany()

    },

     mounted() {
        this.$store.dispatch('authUser');
    },

    methods: {

        getCurrentLabor(labor) {
            return this.getLabor = labor;
        },

        // newLabor(event){
        //     console.log(this.labors.unshift(event));
        // },

        // Get Master Data

        getLabors() {
            this.loading = true
            axios.get('/getLaborByCompany/'+this.company_id)
            .then(response => {
                this.labors = response.data
                this.loading = false
            });
        },

        getCompany() {
            axios.get('/getCompany/'+this.company_id)
            .then(response => this.company = response.data);
        },

        // Create and Update method

        findLabor(labor_id) {
            for(var key = 0; key < this.labors.length; key++) {
                if(this.labors[key].id == labor_id) {
                    return key;
                }
            }
        },

        changeStatus(labor) {
            axios.patch('/changeStatus/'+ labor.id, {
                status : labor.status
            })
            .then(response => {
                this.labors[this.findLabor(labor.id)] = response.data
                labor.status == 0 ? labor.status = 1 : labor.status = 0
                Vue.toasted.show("Successfully Updated!", {
                    theme: "primary",
                    position: "bottom-right",
                    duration : 5000
                });
            })
        },

        storeReliever() {
            axios.post('/relievers', {
                user_id: 1,
                status: 1,
                from_worker: this.getLabor.id,
                to_worker: this.selectedToWorker,
                from_date: this.fromDate,
                to_date: this.toDate,
                reasons: this.reasons,
                company_list: this.company.id
            })
            .then(response => {
                window.location = response.data.redirect;
            })
        },

        checkPermission(slug) {
            return this.currentUser.some(current => current.slug == slug);
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
        ...mapState(['currentUser']),

        allowToSubmit() {
            return this.selectedToWorker == '' ||
                this.fromDate == '' ||
                this.toDate == '' ||
                this.reasons == '';
        },

        filterActiveLabors() {
            return this.labors.filter(labor => labor.id != this.getLabor.id);
        },

        filteredEntries() {
            return this.labors.filter(item => {
                return item.name.toLowerCase().includes(this.search.toLowerCase());
            })
        },

        laborsFiltered() {

            var bySearch = this.filteredEntries;

            if(this.filter == 'all') {
                return this.labors && bySearch;
            } else if(this.filter == 'active') {
                return this.labors.filter(labor => {
                    return labor.status == 1 && labor.name.toLowerCase().includes(this.search.toLowerCase());
                })
            } else if(this.filter == 'inactive') {
                return this.labors.filter(labor => {
                    return labor.status == 0 && labor.name.toLowerCase().includes(this.search.toLowerCase());
                })
            }

            return this.labors;
        },

        currentDate() {
            return moment().format('YYYY-MM-DD');
        },

        totalPages() {
            return Math.ceil(this.laborsFiltered.length / this.itemsPerPage)
        },

        filteredQueues() {
            var index = this.currentPage * this.itemsPerPage;
            var queues_array = this.laborsFiltered.slice(index, index + this.itemsPerPage);

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
