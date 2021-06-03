//BasicSettings
//общие настройки
<template>
    <div class="text-center">
        <h3>BasicSettings.vue</h3>
    </div>
</template>
<script>
export default {
    //хуки
    mounted(){
        this.$parent.currentTab = 'basicSettings';
    }
}
</script>