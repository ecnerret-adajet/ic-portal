<template>
    <div>
        

         <table class="table table-hover">
            <thead>
                <tr class="text-uppercase small">
                    <th>From Worker</th>
                    <th>To Worker</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Approved By</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(reliever, l) in filteredQueues" :key="l" v-if="!loading">
                    <td>{{ reliever.from_worker }}</td>
                    <td>{{ reliever.to_worker }}</td>
                    <td>{{ moment(reliever.from_date) }}</td>
                    <td>{{ moment(reliever.to_date) }}</td>
                    <td>{{ reliever.approved }}</td>
                </tr>
                <tr v-if="filteredQueues.length == 0 && !loading">
                    <td colspan="5" class="text-center" >
                        <h4 class="mt-3 text-muted text-uppercase">Nothing found</h4>
                    </td>
                </tr>
                <tr v-if="loading">
                    <td colspan="5">
                         <div class="row">
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
                    </td>
                </tr>
            </tbody>

        </table> 

         <div class="row mt-3">
            <div class="col-6">
                <button :disabled="!showPreviousLink()" class="btn btn-default btn-sm" v-on:click="setPage(currentPage - 1)"> Previous </button>
                    <span class="text-dark">Page {{ currentPage + 1 }} of {{ totalPages }}</span>
                <button :disabled="!showNextLink()" class="btn btn-default btn-sm" v-on:click="setPage(currentPage + 1)"> Next </button>
            </div>
            <div class="col-6 text-right">
                <span>{{ relievers.length }} Labor(s)</span>
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
            axios.get('/icportal/public/getRelievers/')
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
