//HomeProjects
//управление проектами на главной странице сайта
<template>
    <div class="row justify-content-center" v-if="currentProject !== -1">

        <div class="col-8">
            <Error v-if="projectsList === -1" errorMessage="Не удалось загрузить список проектов"/>

            <div v-if="projectsList === false" class="row justify-content-center text-center goUpAnim">
                <div class="col-12">
                    <h3>Нет главных проектов</h3>
                <i class="bi bi-file-earmark-check font1-8rem"></i>
                <hr>
                <h5>Их можно добавить в разделе  <router-link to="/admin/projects/all"><b>Управление проектами</b></router-link></h5>
                </div>
            </div>

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