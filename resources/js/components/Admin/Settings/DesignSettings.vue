//DesignSettings
//настройки дизайна
<template>
    <div class="text-center">
        <h3>DesignSettings.vue</h3>
    </div>
</template>
<script>
export default {
    //хуки
    mounted(){
        this.$parent.currentTab = 'designSettings';
    }
}
</script>