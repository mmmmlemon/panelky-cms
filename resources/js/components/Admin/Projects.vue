//Projects
//вкладка в админке, список проектов
<template>
    <div class="row mt-5 justify-content-center fadeInAnim">
        <div class="col-8">
            <div class="row">
                <div class="col-4">
                    <ListOfProjects :projectsList="projectsList"/>
                </div>
                <div class="col-8 transparentCard">
                    Preview
                </div>
            </div>       
        </div>
    </div>
</template>

<script>
export default {
    
    beforeMount(){
        this.$store.dispatch('setCurrentTab', 'projects');
        this.$store.dispatch('getProjectsList', 'projects');
    },

    computed: {
        projectsList: function(){
            return this.$store.state.AdminStates.projectsList;
        }
    }

}
</script>