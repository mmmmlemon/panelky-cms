//PreviewProject
//превью проекта в админке
<template>
    <div class="col-12 d-flex h-100 justify-content-center animatedBackground previewCard fadeInAnim" v-if="currentProject !== -1">
        <!-- мини превью -->
        <div v-if="type === 'mini'" class="row text-center textVertical">
            <div class="col-12">
                <h1 class="text-center textVertical font3-8rem">
                    <b>{{currentProject.project_title}}</b>    
                </h1>  
            </div>
            <div class="col-12">
                <img :src="currentProject.project_icon" width="10%">
            </div>
            <div class="col-12">
                <p class="text-center textVertical font2rem">
                   {{currentProject.project_subtitle}}
                </p>
            </div>
           
            <div class="col-12">
                <hr>
                    <router-link :to="'/admin/edit/'+currentProject.slug">
                        <button class="btn btn-light mr-3" title="Редактировать">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                    </router-link>
                    
                    <button class="btn btn-light ml-3" title="Удалить"  v-on:click="deleteProject">
                        <i class="bi bi-trash-fill"></i>
                    </button>
            </div> 
        </div>   
        <!-- полное превью -->
        <div v-if="type==='full'" class="row justify-content-center zIndex3">
            <ProjectCard :project="currentProject"/>
            <!-- кнопка развернуть на весь экран -->
            <button class="btn btn-light fullscreenButton" title="Развернуть на полный экран" v-on:click="showFullscreenPreview">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>
        </div>
        <!-- превью на весь экран -->
        <div class="container col-12 vh-100 animatedBackground fullscreenCard zIndex3" :style="fullscreenStyle">
            <button class="btn btn-light btn-lg fullscreenButton" title="Свернуть" v-on:click="closeFullscreenPreview">
                <i class="bi bi-fullscreen-exit"></i>
            </button>
            <div class="row h-100 justify-content-center">
                <ProjectCard :project="currentProject"/>
            </div>
        </div>
    </div>
</template>
<script>
export default {

    mounted(){
        this.$parent.$parent.$parent.deleteModal = 1;
    },

    //данные
    data: () => {
        return {
            fullscreenStyle: undefined,
        }
    },

    props: {
            type: {type: String, default: 'mini'},
            currentProject: { type: Object, default: function() {
                return {
                    'id': undefined,
                    'project_bottomText': undefined,
                    'project_desc': undefined,
                    'project_icon': undefined,
                    'project_image': undefined,
                    'project_subtitle': undefined,
                    'project_title': undefined,
                    'project_url': undefined
                }
            }}
        },
    
    //методы
    methods: {
        //показать превью на полный экран
        showFullscreenPreview: function(){
            this.fullscreenStyle = { left: '0px', opacity: 1 };
        },
        //свернуть превью на полный экран
        closeFullscreenPreview: function(){
            this.fullscreenStyle = { left: '5000px', opacity: 0 };
        },
        //удалить проект
        deleteProject(){
            this.$store.dispatch('setDeleteModalInfo', {deleteInfo: this.currentProject, page: 'homeProjects'});
        }
    }

}
</script>