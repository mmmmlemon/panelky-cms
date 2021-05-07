//Projects
//вкладка в админке, список проектов
<template>
    <div class="row mt-5 justify-content-center fadeInAnim" v-if="currentProjectId !== -1 && currentProject !== -1">
        <div class="col-8">
            <div class="row">
                <div class="col-4">
                    <ListOfProjects v-if="projectsList !== -1" :projectsList="projectsList"/>
                </div>
                <div class="col-8 transparentCard">
                   <PreviewProject :currentProject="currentProject"/>
                </div>
            </div>       
        </div>
    </div>
</template>

<script>
export default {
    
    beforeMount(){
        this.$store.dispatch('setCurrentTab', 'projects');
        this.$store.dispatch('getProjectsList');
        this.$store.dispatch('setFirstProjectId');
    },

    mounted(){

    },

    computed: {
        projectsList: function(){
            return this.$store.state.AdminStates.projectsList;
        },

        currentProjectId: function(){
            return this.$store.state.AdminStates.currentProjectId;
        },

        currentProject: function(){
            return this.$store.state.AdminStates.currentProject;
        }

    },
}
</script>