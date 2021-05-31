//EditContacts
//форма редактирования e-mail
<template>
    <div class="row justify-content-center">
        <h1 class="text-center">EditContacts.vue</h1>
    </div>
</template>
<script>
export default {
    //хуки
    mounted(){
        //текущая вкладка в Links.vue
        this.$parent.currentTab = "editContacts";
    }
}
</script>