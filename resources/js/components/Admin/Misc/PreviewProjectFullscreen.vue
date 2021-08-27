//PreviewProject
//превью проекта в админке
<template>
    <div class="col-12 d-flex h-100 justify-content-center previewCard fadeInAnim" v-bind:style="animatedBackground" v-if="currentProject !== -1">
        <!-- превью на весь экран -->
        <div class="container col-12 vh-100 animatedBackground fullscreenCard " :style="fullscreenStyle">

            <div class="fullscreenButtons zIndex7">
                <ul class="nav nav-pills justify-content-right">
                    <!-- кнопка ориентации -->
                    <li class="nav-item d-none d-md-block m-1">
                        <button class="btn btn-light btn-lg" title="Изменить ориентацию" 
                        v-on:click="changeOrientation" 
                        v-if="currentProject.project_image !== null 
                        && currentProject.project_image !== undefined && screenOrientation === 'horizontal'">
                                <i class="bi bi-arrow-left-right"></i>
                        </button>
                    </li>
                        <!-- кнопка свернуть -->
                    <li class="nav-item m-1">
                        <button class="btn btn-light btn-lg" title="Закрыть превью" v-on:click="closeFullscreenPreview">
                            <i class="bi bi-x"></i>
                        </button>
                    </li>
                </ul>
            </div>
  
            <div class="row h-100 justify-content-center zIndex3">
                <ProjectCard :project="currentProject" :type="orientation" :isVisible="true" class="zIndex3"/>
            </div>
        </div>
    </div>
</template>
<script>
export default {

    //данные
    data: () => {
        return {
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

        fullscreenStyle: function(){
            let style = {left: '0px', opacity: 1, 
                        background: this.animatedBackground.background,
                        backgroundSize: this.animatedBackground.backgroundSize,
                        backgroundRepeat: this.animatedBackground.backgroundRepeat};

            return style;
        },

        screenOrientation: function(){
            return this.$store.state.GlobalStates.screenOrientation;
        },

        currentSlide: function(){
            return this.$children[0]['data'];
        }
    },
    
    //методы
    methods: {

        //свернуть превью на полный экран
        closeFullscreenPreview: function(){
            this.$parent.currentTab = this.$parent.previousTab;
        },
        //сменить ориентацию в превью на полный экран
        changeOrientation(){
            if(this.orientation === 'left')
            this.orientation = 'right';
            else
            this.orientation = 'left';
        },
    }
}
</script>