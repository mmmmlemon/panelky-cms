<template>
    <div class="row justify-content-center">
        <div class="col-12 mt-5 text-center fadeInAnim">
            <h2>Links.vue</h2>
        </div>
    </div>
</template>

<script>
export default {
    
    beforeMount(){
        this.$store.dispatch('setCurrentTab', 'links');
    },
    
}
</script>