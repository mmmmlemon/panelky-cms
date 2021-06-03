//HomeSettings
//настройки главной страницы
<template>
    <div class="text-center">
        <h3>HomeSettings.vue</h3>
    </div>
</template>
<script>
export default {
    //хуки
    mounted(){
        this.$parent.currentTab = 'homeSettings';
    }
}
</script>