//HomeProjects
//управление проектами на главной странице сайта
<template>
    <div class="row justify-content-center " v-if="currentProject !== -1 && visible === true">
        <div class="col-12 col-md-10 mb-2">
            
            <!-- сообщение если нет проектов -->
            <div v-if="projectsList === false" class="row justify-content-center text-center goUpAnim">
                <div class="col-12">
                    <h3>Нет главных проектов</h3>
                    <i class="bi bi-file-earmark-check font1-8rem"></i>
                    <hr>
                    <h5>Их можно добавить в разделе  <router-link to="/admin/projects/all"><b>Управление проектами</b></router-link></h5>
                </div>
            </div>

            <div class="row justify-content-center" v-if="projectsList !== -1 && projectsList !== false">
                <!-- список проектов -->
                <div class="col-12 col-md-4">
                    <h6>Порядок</h6>
                    <hr>
                    <ListOfProjects :projectsList="projectsList"/>      
                </div>
                <!-- мини-превью проекта -->
                <div class="col-12 col-md-6 fadeInAnim">
                     <h6>&nbsp;</h6>
                    <hr>
                    <PreviewProject type="mini" :currentProject="currentProject"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    //хуки
    mounted(){
        //текущая вкладка
        this.$store.dispatch('setCurrentTab', 'projects');
        //получить список проектов
        this.$store.dispatch('getProjectsList');

        var currentProject = this.$store.getters.currentProject;

        if(currentProject === -1)
        {   
            //установить первый проект в списке выбранным по умолчанию
            this.$store.dispatch('setFirstProjectSlug');
            this.visible = true;
        }
        else if (currentProject !== -1 && currentProject !== false && currentProject.is_home === 0){
            this.$store.dispatch('setFirstProjectSlug');
            this.visible = true;
        }
        else {
            this.visible = true;
        }
    },

    data: () => {
        return {
            visible: false,
        }
    },

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