//AllProjects
//список всех проектов
<template>
    <div class="row justify-content-center text-center" v-if="allProjects !== -1">

        <div class="col-4 m-1">
            <h4>Проекты на главной</h4>
                <transition-group name="projectsList" tag="div" class="row justify-content-center">
                    <div v-for="project in allProjects.home" :key="project.slug" class="col-12 transparentCard highlighted m-1">
                                <div class="card-body">
                                    <h2 class="card-title">{{project.project_title}}</h2>
                                    <hr>
                                    <p class="card-text">{{project.project_subtitle}}</p>
                                    <div class="d-grid gap-2 d-md-block">
                                        <button class="btn btn-light" type="button">
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
             
                                <button class="btn btn-light" type="button">
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
    }
}
</script>