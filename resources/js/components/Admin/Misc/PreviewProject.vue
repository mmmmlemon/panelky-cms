//PreviewProject
//превью проекта в админке
<template>
    <div class="col-12 d-flex h-100 justify-content-center previewCard fadeInAnim" v-bind:style="animatedBackground" v-if="currentProject !== -1">
        <!-- МИНИ ПРЕВЬЮ (в HomeProjects.vue) -->
        <div v-if="type === 'mini'" class="row text-center textVertical">
            <!-- название -->
            <div class="col-12">
                <h1 class="text-center textVertical font3-8rem">
                    <b>{{currentProject.project_title}}</b>    
                </h1>  
            </div>
            <!-- лого -->
            <div class="col-12">
                <img :src="currentProject.project_icon" width="10%">
            </div>
            <!-- подзаголовок -->
            <div class="col-12">
                <p class="text-center textVertical font2rem">
                   {{currentProject.project_subtitle}}
                </p>
            </div>
            <!-- кнопки -->
            <div class="col-12">
                <hr>
                <!-- ред. -->
                <router-link :to="'/admin/edit/'+currentProject.slug">
                    <button class="btn btn-light mr-3" title="Редактировать">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                </router-link>
                <!-- удалить -->
                <button class="btn btn-light ml-3" title="Удалить"  v-on:click="deleteProject">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </div> 
        </div>

        <!-- ПОЛНОЕ ПРЕВЬЮ (в EditProject.vue) -->
        <div v-if="type==='full'" class="row justify-content-center zIndex3">
            <!-- карточка проекта -->
            <ProjectCard :project="currentProject" :isVisible="true"/>
            <!-- кнопка развернуть на весь экран -->
            <button class="btn btn-light fullscreenButton" title="Развернуть на полный экран" v-on:click="showFullscreenPreview">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>
        </div>
        <!-- превью на весь экран -->
        <div class="container col-12 vh-100 animatedBackground fullscreenCard zIndex3" :style="fullscreenStyle">
            <div class="fullscreenButtons">
                <ul class="nav nav-fill">
                    <!-- TODO шознах тут с версткой, переделать -->
                    <!-- кнопка ориентации -->
                    <li class="nav-item" v-if="currentProject.project_image !== null && currentProject.project_image !== undefined">
                         <button class="btn btn-light btn-lg fullscreenButton" title="Изменить ориентацию" v-on:click="changeOrientation">
                            <i class="bi bi-arrow-left-right"></i>
                        </button>
                    </li>
                </ul>
            </div>
  
            <!-- кнопка свернуть -->
            <button class="btn btn-light btn-lg fullscreenButton" title="Свернуть" v-on:click="closeFullscreenPreview">
                <i class="bi bi-fullscreen-exit"></i>
            </button>
            <div class="row h-100 justify-content-center">
                <ProjectCard :project="currentProject" :type="orientation" :isVisible="true"/>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    //данные
    data: () => {
        return {
            fullscreenStyle: undefined,
            orientation: 'left',
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
    
    computed: {
        animatedBackground: function(){
            return this.$store.state.AdminStates.animatedBackground;
        },
    },
    
    //методы
    methods: {
        //показать превью на полный экран
        showFullscreenPreview: function(){
            this.orientation = 'left';
            this.fullscreenStyle = { left: '0px', opacity: 1 };
            this.fullscreenStyle.background = this.animatedBackground.background;
            this.fullscreenStyle.backgroundSize =  this.animatedBackground.backgroundSize;
            this.fullscreenStyle.backgroundRepeat = this.animatedBackground.backgroundRepeat;

        },
        //свернуть превью на полный экран
        closeFullscreenPreview: function(){
            this.fullscreenStyle.left = '5000px';
            this.fullscreenStyle.opacity = 0;
        },
        //сменить ориентацию в превью на полный экран
        changeOrientation(){
            if(this.orientation === 'left')
            this.orientation = 'right';
            else
            this.orientation = 'left';
        },
        //удалить проект
        deleteProject(){
            this.$store.dispatch('setDeleteModalInfo', {deleteInfo: {project_title: this.currentProject.project_title, slug: this.currentProject.slug}, page: 'homeProjects', type: 'project'});
        }
    }
}
</script>