//Projects
//вкладка в админке, список проектов
<template>
   <div class="row mt-5 justify-content-center fadeInAnim">

       <div v-for="project in projectsList" v-bind:key="project.id" class="col-12 m-3">
           <div class="row justify-content-center">
                <PreviewProject type="mini" :projectInfo="{title: project.title, 'icon': project.icon, 'subtitle': project.subtitle}"/>
           </div>
       </div>

       <!-- <div class="col-12 m-3">
           <div class="row justify-content-center">
                <PreviewProject type="mini" :projectInfo="{title:'SpotiFYI', 'icon': '/stock/spoti_logo.png', 'subtitle': 'Music statistics for Spotify'}"/>
           </div>

       </div>

        <div class="col-12 m-3">
            <div class="row justify-content-center">
                <PreviewProject type="mini" :projectInfo="{title:'Weird Web-Site of [Mr. o_O]', 'icon': '/stock/mr_logo.png', 'subtitle': 'Videoblog page'}"/>
            </div>
        </div> -->

        
    </div>
</template>

<script>
export default {
    
    beforeMount(){
        this.$store.dispatch('setCurrentTab', 'projects');
        this.$store.dispatch('getProjectsList', 'projects');
    },

    computed: {
        projectsList: function(){
            return this.$store.state.AdminStates.projectsList;
        }
    }

}
</script>