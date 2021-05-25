//AllProjects
//список всех проектов
<template>
    <div class="row justify-content-center text-center fadeInAnim" v-if="allProjects !== -1">
        <div class="col-4 m-1">
            <h4>Главные проекты</h4>
            <hr>
            <h6>Отображаются в самом начале в виде карточек</h6>
                <div class="col-12 mt-5 goUpAnim" v-if="allProjects.home.length === 0">
                    <h3>Нет главных проектов</h3>
                    <i class="bi bi-file-earmark-x font18pt"></i>
                    <hr>
                </div>
                <transition-group name="projectsList" tag="div" class="row justify-content-center">
                    <div v-for="project in allProjects.home" :key="project.slug" class="col-12 transparentCard highlighted m-1">
                        <div class="card-body">
                            <h2 class="card-title">{{project.project_title}}</h2>
                            <hr>
                            <p class="card-text">{{project.project_subtitle}}</p>
                            <div class="d-grid gap-2 d-md-block">
                                <button class="btn btn-light" type="button" v-on:click="deleteProject(project)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                <router-link class="btn btn-light" :to="`/admin/edit/${project.slug}`">
                                        <i class="bi bi-pencil-fill"></i>
                                </router-link>   
                                <button class="btn btn-light" type="button"
                                            v-on:click="setProjectStatus(project.slug)">
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </transition-group>
        </div>
        <div class="col-4 m-1">
            <h4>Другие проекты</h4>
            <hr>
            <h6>Отображаются в самом конце в виде названий</h6>
            <div class="col-12 mt-5 goUpAnim" v-if="allProjects.other.length === 0">
                    <h3>Нет проектов</h3>
                    <i class="bi bi-file-earmark-x font18pt"></i>
                    <hr>
                </div>
            <transition-group name="projectsList" tag="div" class="row justify-content-center">
               <div v-for="project in allProjects.other" :key="project.slug" class="col-12 transparentCard m-1">
                        <div class="card-body">
                            <h2 class="card-title">{{project.project_title}}</h2>
                            <hr>
                            <p class="card-text">{{project.project_subtitle}}</p>
                            <div class="d-grid gap-2 d-md-block">
                                <button class="btn btn-light" type="button"
                                            v-on:click="setProjectStatus(project.slug)">
                                    <i class="bi bi-arrow-left"></i>
                                </button>
          
                                <router-link class="btn btn-light" :to="`/admin/edit/${project.slug}`">
                                        <i class="bi bi-pencil-fill"></i>
                                </router-link>   
             
                                <button class="btn btn-light" type="button" v-on:click="deleteProject(project)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </div>
                  
                </div>
            </transition-group>
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

        //удалить проект
        deleteProject(project){

            this.$store.dispatch('setDeleteModalInfo', {deleteInfo: project, page: 'allProjects'});
          
        }
    }
}
</script>