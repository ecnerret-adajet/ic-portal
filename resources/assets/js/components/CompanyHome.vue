<template>
    <div class="row">
        <div class="col" v-for="(company, c) in companies" :key="c">
            <div class="card bg-light mb-3">
            <div class="card-body text-center">
                <h3 class="card-title mt-5 p-5 text-muted">{{ company.name }}</h3>
            </div>
            <div class="card-footer">
                <a :href="'/icportal/public/companies/' + company.id ">
                    Visit Now
                </a>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    
    data() {
        return {
            companies: []
        }
    },

    created() {
        this.getCompanies()
    },

    methods: {
        getCompanies() {
            axios.get('/icportal/public/getCompanies')
            .then(response => this.companies = response.data);
        }
    }

}
</script>
