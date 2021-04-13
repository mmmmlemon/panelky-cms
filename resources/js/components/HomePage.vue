//HomePage
//домашняя страница
<template>
    <div class="row h-100 justify-content-center">

        <HeaderCard 
            :info="siteOwnerInfo"/>

        <ProjectCard id="spotifyi"
            type='left'
            projectName="SpotiFYI"
            projectUrl="http://spotifyi.ru"
            projectDescription="Music statistics for Spotify"
            fullDescription="An projectlication for Spotify users that provides them an ability to see their music habits and statistic in an accesible form. " 
            footer="Laravel / Vue.js / Spotify API"/>

        <ProjectCard 
            type='right'
            projectName="Weird Web-Site of [Mr. o_O]"
            projectUrl="https://mistermisteroo.ru"
            projectDescription="Videoblog page"
            fullDescription="A CMS for videos and images."
            footer="Laravel / MySQL" />
        
        <FooterCard />
        
    </div>
</template>
<script>
export default {
    beforeCreate(){
        this.$store.dispatch('getSiteOwnerInfo');
    },

    computed: {
        siteOwnerInfo: function(){
             
             return this.$store.state.GlobalStates.siteOwnerInfo;
        }
    }

}
</script>
