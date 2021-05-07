//PreviewProject
//превью проекта в админке
<template>
    <div>
        <h1>{{currentProject.project_title}}</h1>
        <img :src="currentProject.project_icon" width="10%">
        <h3>{{currentProject.project_subtitle}}</h3>
        <h5>{{currentProject.project_desc}}</h5>

        <a :href="currentProject.project_url" target="_blank">Link</a>
        
    </div>
</template>
<script>
export default {
    
    props: {
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
    }

}
</script>