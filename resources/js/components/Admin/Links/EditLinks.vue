//EditLinks
//форма редактирования ссылок
<template>
    <div class="row justify-content-center">
        <h1 class="text-center">EditLinks.vue</h1>
    </div>
</template>
<script>
export default {
    //хуки
    mounted(){
        //текущая вкладка в Links.vue
        this.$parent.currentTab = "editLinks";
    }
}
</script>