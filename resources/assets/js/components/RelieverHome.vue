<template>
    <div>
        

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="header pl-4">
                        <h4 class="title mb-0">Relievers</h4>
                        <p class="category text-muted">Assigned Relievers</p>          

                    <div class="row mb-2">
                        <div class="col float-left">
                            <div class="form-group w-100">
                                <input type="text" class="form-control" placeholder="Search by name" v-model="search">
                            </div>
                        </div>
                        <div class="col text-right mr-4">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-primary btn-primary active">
                                    <input type="checkbox" checked="" autocomplete="off"> Pending
                                </label>
                                <label class="btn btn-outline-primary btn-primary">
                                    <input type="checkbox" autocomplete="off"> Approved
                                </label>
                            </div>
                        </div>
                    </div>

                    </div>
                <!-- end header -->

                <div class="content table-responsive">
                     <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                <th>From Worker</th>
                                <th>To Worker</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Company</th>
                                <th>Approved By</th>
                                </tr>
                            </thead>
                        <tbody>
                             <tr v-for="(reliever, l) in filteredQueues" :key="l" v-if="!loading">
                                <td>{{ reliever.from_worker }}</td>
                                <td>{{ reliever.to_worker }}</td>
                                <td>{{ moment(reliever.from_date) }}</td>
                                <td>{{ moment(reliever.to_date) }}</td>
                                <td>
                                    <span v-if="reliever.company">
                                        {{ reliever.company.name }}
                                    </span>
                                    <span v-else>
                                        No Company
                                    </span>
                                </td>
                                <td>{{ reliever.approved }}</td>
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
                                <span>{{ relievers.length }} Labor(s)</span>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
        </div>

    </div>
</template>
<script>
import moment from 'moment';
import VueContentPlaceholders from 'vue-content-placeholders';
export default {
    data() {
        return {
            loading: false,
            relievers: [],
            currentPage: 0,
            itemsPerPage: 10,
            search: '',
        }
    },

    created() {
        this.getRelievers()
    },

    methods: {
        getRelievers() {
            this.loading = true
            axios.get('/getRelievers/')
            .then(response => {
                this.relievers = response.data
                this.loading = false
            });
        },

        moment(date) {
            return moment(date).format('MMMM D, Y h:m:s A');
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
         filteredEntries() {
            return this.relievers.filter(item => {
                return item.from_worker.toLowerCase().includes(this.search.toLowerCase());
            })
        },

        currentDate() {
            return moment().format('YYYY-MM-DD');
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
