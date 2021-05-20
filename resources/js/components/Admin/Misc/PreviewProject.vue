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
                    
                    <button class="btn btn-light ml-3" title="Удалить">
                        <i class="bi bi-trash-fill"></i>
                    </button>
            </div> 
        </div>   
        <!-- полное превью -->
        <div v-if="type==='full'" class="row justify-content-center zIndex3">
            <ProjectCard :project="currentProject"/>
            <!-- кнопка развернуть на весь экран -->
            <button class="btn btn-light fullscreenButton" title="Развернуть на полный экран">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>
        </div>
    </div>
</template>
<script>
export default {

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

}
</script>