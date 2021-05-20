//AddNewProject
//меню добавления нового проекта
<template>
    <div class="row justify-content-center">
        <h4>AddNewProject.vue</h4>
    </div>
</template>
<script>
export default {
    mounted(){
        this.$parent.currentTab = 'addProject';
    }
}
</script>