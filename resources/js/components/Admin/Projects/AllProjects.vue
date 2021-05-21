//AllProjects
//список всех проектов
<template>
    <div class="row justify-content-center text-center" v-if="allProjects !== -1">
        <div class="col-12">
            <h4>Проекты на главной</h4>
            <div class="row justify-content-center">
                <div v-for="project in allProjects.home" :key="project.slug" class="col-3 transparentCard m-1">
                    <div class="col-10 text-center align-middle">
                        <h2 style="margin-top:10%;">{{project.project_title}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-5">
            <h4>Другие проекты</h4>
            <div class="row justify-content-center">
                <div v-for="project in allProjects.other" :key="project.slug" class="col-3 transparentCard m-1">
                    <div class="col-10 text-center align-middle">
                        <h2 style="margin-top:10%;">{{project.project_title}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    //хуки
    mounted(){
        this.$parent.currentTab = "allProjects";
        this.$store.dispatch('getAllProjects');
    },

    //данные
    computed: {
        allProjects: function(){
            return this.$store.state.AdminStates.allProjects;
        }
    }

}
</script>