<template>
    <div>

        <button class="btn btn-secondary btn-fill" data-toggle="modal" data-target="#addLabor">
            Add New Labor
        </button>

         <!-- Add Labor -->
        <div class="modal fade text-left" id="addLabor" tabindex="-1" role="dialog" aria-labelledby="addLabor" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLabor">Add New Labor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" v-model="labor.name">
                </div>

                <div class="form-group">
                    <label>Company</label>
                    <input type="text" disabled class="form-control" v-model="labor.company">
                </div>

                <div class="form-group">
                    <label>Classification</label>
                    <select class="form-control" v-model="labor.classification">
                        <option value=""  selected>Select Classficiation</option>
                        <option v-for="(x,i) in removeResiged" :key="i" selected :value="x.id">{{ x.name }}</option>
                    </select>
                </div>
                
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" @click="storeLabor" data-dismiss="modal">Submit</button>            
            </div>
            </div>
        </div>
        </div>
        <!-- End Labor -->

    </div>
</template>
<script>
export default {

    props: ['company_id'],

    data() {
        return {
            classifications: [],
            companies: [],
            labor: {
                name: '',
                company: '',
                classification:'',
                labor_code: 1,
                card_no: 0,
                user_id: 1,
                status: 1,
            }
        }
    },

    created() {
        this.getClassifications()
        this.getCompanies()
    },

    watch: {
        filterCompany() {
            return this.labor.company = this.filterCompany.name;
        }
    },

    methods: {
        getClassifications() {
            axios.get('/icportal/public/getClassifications')
            .then(response => this.classifications = response.data);
        },

        getCompanies() {
            axios.get('/icportal/public/getCompanies')
            .then(response => this.companies = response.data);
        },

        storeLabor() {
            axios.post('/icportal/public/labors', {
                user_id: this.labor.user_id,
                name: this.labor.name,
                labor_code: this.labor.labor_code,
                card_no: this.labor.card_no,
                company_list: this.company_id,
                classification_list : this.labor.classification,
                status: this.labor.status
            })
            .then(response => {
                this.$emit('pushToLabor',response.data);
            })
        }

    },

    computed: {
        
        filterCompany() {
            if(this.companies) {
                return this.companies.find(company => company.id == this.company_id);
            }
        },

        removeResiged() {
            return this.classifications.filter(classification => classification.name != 'Resigned');
        }

    }

}
</script>
