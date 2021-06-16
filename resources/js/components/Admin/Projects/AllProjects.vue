//AllProjects
//список всех проектов
<template>
    <div class="row justify-content-center text-center fadeInAnim" v-if="allProjects !== -1">
        <!-- Главные проекты -->
        <div class="col-11 col-md-4 mt-md-1 m-1">
            <h4>Главные проекты</h4>
            <hr>
            <h6>Отображаются в самом начале в виде карточек</h6>
                <!-- если нет проектов -->
                <div class="col-12 mt-5 goUpAnim" v-if="allProjects.home.length === 0">
                    <h3>Нет главных проектов</h3>
                    <i class="bi bi-file-earmark-x font18pt"></i>
                    <hr>
                </div>
                <!-- карточки проектов -->
                <transition-group name="projectsList" tag="div" class="row justify-content-center">
                    <div v-for="project in allProjects.home" :key="project.slug" class="col-12 transparentCard highlighted m-1">
                        <div class="card-body">
                            <!--название -->
                            <h2 class="card-title">{{project.project_title}}</h2>
                            <hr>
                            <!-- подзаголовок -->
                            <p class="card-text">{{project.project_subtitle}}</p>
                            <!-- кнопки -->
                            <div class="d-grid gap-2 d-md-block">
                                <!-- удалить -->
                                <button class="btn btn-light" type="button" 
                                        v-on:click="deleteProject(project)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                <!-- ред. -->
                                <router-link class="btn btn-light" :to="`/admin/edit/${project.slug}`">
                                        <i class="bi bi-pencil-fill"></i>
                                </router-link>   
                                <!-- убрать из Главных -->
                                <button class="btn btn-light" type="button"
                                        v-on:click="setProjectStatus(project.slug)">
                                    <i class="d-none d-md-block bi bi-arrow-right"></i>
                                    <i class="d-block d-md-none bi bi-arrow-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </transition-group>
        </div>
        <!-- Другие проекты -->
        <div class="col-11 col-md-4 m-1 mt-md-1 mt-5 ">
            <h4>Другие проекты</h4>
            <hr>
            <h6>Отображаются в самом конце в виде названий</h6>
            <!-- если нет проектов -->
            <div class="col-12 mt-5 goUpAnim" v-if="allProjects.other.length === 0">
                <h3>Нет проектов</h3>
                <i class="bi bi-file-earmark-x font18pt"></i>
                <hr>
            </div>
            <!-- карточки проектов -->
            <transition-group name="projectsList" tag="div" class="row justify-content-center">
               <div v-for="project in allProjects.other" :key="project.slug" class="col-12 transparentCard m-1">
                    <div class="card-body">
                        <!-- название -->
                        <h2 class="card-title">{{project.project_title}}</h2>
                        <hr>
                        <!-- подзаголовок -->
                        <p class="card-text">{{project.project_subtitle}}</p>
                        <!-- кнопки -->
                        <div class="d-grid gap-2 d-md-block">
                            <!-- переместить в Главные -->
                            <button class="btn btn-light" type="button"
                                        v-on:click="setProjectStatus(project.slug)" 
                                        :disabled="allProjects.home.length >=5">
                                <i class="d-block d-md-none bi bi-arrow-up"></i>
                                <i class="d-none d-md-block bi bi-arrow-left"></i>
                            </button>
                            <!-- ред. -->
                            <router-link class="btn btn-light" :to="`/admin/edit/${project.slug}`">
                                    <i class="bi bi-pencil-fill"></i>
                            </router-link>   
                            <!-- удалить -->
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
        //текущая вкладка в Projects.vue
        this.$parent.currentTab = "allProjects";
        //получить список всех проектов
        this.$store.dispatch('getAllProjects');
    },

    //данные
    computed: {
        //все проекты
        allProjects: function(){
            return this.$store.state.AdminStates.allProjects;
        }
    },

    //методы
    methods: {
        //переместить проект в Главные или убрать из Главных
        setProjectStatus: function(slug){
            let formData = new FormData();
            formData.append('slug', slug);

            axios.post('/api/setProjectStatus', formData).then(response => {
                this.$store.dispatch('getAllProjects');
            }).catch(error => {
               if(error.response.status === 422 || error.response.status === 500){ 
                    var errors = error.response.data;
                    this.$store.dispatch('setErrors', error.response.data.message);
                    }
                });
        },

        //удалить проект
        deleteProject(project){
            this.$store.dispatch('setDeleteModalInfo', {deleteInfo: {project_title: project.project_title, slug: project.slug}, page: 'allProjects', type: 'project'});
        }
    }
}
</script>