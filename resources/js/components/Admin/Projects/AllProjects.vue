//AllProjects
//список всех проектов
<template>
    <div class="row justify-content-center text-center" v-if="allProjects !== -1">
        <div class="col-12">
            <h4>Проекты на главной</h4>
            <div class="row justify-content-center">
                <div v-for="project in allProjects.home" :key="project.slug" class="col-3 transparentCard m-1">
                    <div class="col-10 text-center align-middle"
                         v-on:click="setProjectStatus(project.slug)">
                        <h2 style="margin-top:10%;">{{project.project_title}}</h2>
                    </div>
                </div>
                <div class="col-12">&nbsp;</div>
                <div v-for="project in allProjects.other" :key="project.slug" class="col-3 transparentCard m-1">
                    <div class="col-10 text-center align-middle"
                        v-on:click="setProjectStatus(project.slug)">
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
    },

    //методы
    methods: {
        setProjectStatus: function(slug){
            let formData = new FormData();
            formData.append('slug', slug);

            axios.post('/api/setProjectStatus', formData).then(response => {
                this.$store.dispatch('getAllProjects');
            }).catch(error => {
                alert("Error");
            })
        },
    }
}
</script>