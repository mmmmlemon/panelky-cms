//Links
//ссылки и контакты
<template>
    <div class="row justify-content-center">
        <div class="col-12 mt-5 text-center fadeInAnim">
            <h2>Settings.vue</h2>
        </div>
    </div>
</template>

<script>
export default {
    //хуки
    beforeMount(){
        this.$store.dispatch('setCurrentTab', 'settings');
    },
    
}
</script>