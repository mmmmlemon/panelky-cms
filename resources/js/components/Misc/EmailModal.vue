// EmailModal
<template>
    <div class="deleteModalBody fadeInAnim zIndex7">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 text-center p-3 transparentCard emailModalCardSmall marginTop">
                <div class="card-body">
                    <div class="col-12">
                        <h3 class="pointer">{{email}}</h3>
                    </div>
                </div>
                <div class="row justify-content-center fadeInAnim">
                    <button type="button" class="btn btn-lg btn-primary" @click="closeEmail()">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {

    mounted(){
        document.body.style.overflow = 'hidden';
    },

    beforeDestroy() {
        document.body.style.overflow = '';
    },

    props: {
        email: { type: String, default: null}
    },

    methods: {
        closeEmail(){
            this.$parent.showEmailModal = false;
            this.$parent.emailModal = null;


        }
        
    }
}
</script>