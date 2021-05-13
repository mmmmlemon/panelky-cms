//Projects
//вкладка в админке, список проектов
<template>
    <div class="row mt-5 justify-content-center fadeInAnim" v-if="currentProject !== -1 && currentProject !== false">
        <div class="col-8">

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
    </div>
</template>

<script>
export default {
    
    //хуки
    beforeMount(){
        //текущая вкладка
        this.$store.dispatch('setCurrentTab', 'projects');
        //получить список проектов
        this.$store.dispatch('getProjectsList');
    },

    mounted(){
        var currentProject = this.$store.getters.currentProject;

        if(currentProject === -1)
        { 
            //установить первый проект в списке выбранным по умолчанию
            this.$store.dispatch('setFirstProjectId');
        }
    },

    //данные
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