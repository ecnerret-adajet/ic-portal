<template>
    <div>

        <div class="modal fade" id="disclaimer" tabindex="-1" role="dialog" aria-labelledby="disclaimer-Label" aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="disclaimer-Label">Terms and Conditions</h3>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col">
                                <p class="disclaimer-body">
                                    By entering this website and accessing the information therein,
                                    you acknowledge and agree that you are authorized to enter into this site using the
                                    unique account and password entrusted to you and that you are responsible for keeping
                                    the same strictly confidential; that you will neither share nor use any information or
                                    content from this site in any instance, including but not limited to legal, judicial,
                                    quasi-judicial or any other similar proceedings, without our consent; that you allow us to
                                    embed a tracking system for us to check on your use; and that should you forget your
                                    password or lose access to your account, you will immediately notify us at
                                    <a href="mailto:ic.portal.lafilgroup.com">ic.portal.lafilgroup.com</a>.
                                </p>
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <div class="row w-100 text-right ml-3">
                            <div class="col">
                                <button type="button" class="btn btn-secondary btn-fill" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Disagree</button>
                                <button type="button" class="btn btn-primary btn-fill" @click="disclaimer">Agree</button>
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

    data() {
        return {
            errors: []
        }
    },

    mounted() {
        $(document).ready(function(){
            $('#disclaimer').modal({
                backdrop: 'static',
                keyboard: false
            })
        });
    },

    methods: {
        disclaimer() {
            axios.post('/disclaimer')
            .then(response => {
                //trigger close modal on success submission
                $('#disclaimer').modal('hide')
                Vue.toasted.show("Welcome to assignment portal!", {
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
    },

}
</script>

<style scoped>
    .disclaimer-body {
         line-height: 2.5em;
         /* text-indent: 50px; */
    }
</style>


