<template>
    <div class="row justify-content-center">
        <div class="col-12 mt-5 text-center fadeInAnim">
            <h2>Projects.vue</h2>
        </div>
    </div>
</template>

<script>
export default {
    
    beforeMount(){
        this.$store.dispatch('setCurrentTab', 'projects');
    },
    
}
</script>