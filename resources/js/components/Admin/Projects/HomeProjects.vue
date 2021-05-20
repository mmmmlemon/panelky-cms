//HomeProjects
//управление проектами на главной странице сайта
<template>
    <div class="row justify-content-center" v-if="currentProject !== -1 && currentProject !== false">

        <Error v-if="projectsList === false" errorMessage="Не удалось загрузить список проектов"/>

        <div class="row" v-if="projectsList !== -1 && projectsList !== false">
            <!-- список проектов -->
            <div class="col-4">
                <ListOfProjects :projectsList="projectsList"/>      
            </div>
            <!-- мини-превью проекта -->
            <div class="col-8 fadeIn">
                <PreviewProject type="mini" :currentProject="currentProject"/>
            </div>
        </div>
   
    </div>
</template>
<script>
export default {
        computed: {
        //список проектов
        projectsList: function(){
            return this.$store.state.AdminStates.projectsList;
        },

        //информация о выбранном проекте для превью
        currentProject: function(){
            return this.$store.state.AdminStates.currentProject;
        }
    },
}
</script>