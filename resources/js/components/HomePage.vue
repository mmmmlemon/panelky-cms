<template>
    <div style="height:100%;" class="row justify-content-center">

        <HeaderCard 
            myName="Egor Zhuravskiy"
            myOccupation="A junior programmer"
            aboutMe="I program programms very programmaly and programmaticly"
            footerText="Check out my projects!"/>

        <ProjectCard
            type='left'
            appName="SpotiFYI"
            appUrl="http://spotifyi.ru"
            appDescription="Music statistics for Spotify"
            fullDescription="An application for Spotify users that provides them an ability to see their music habits and statistic in an accesible form. " 
            footer="Laravel / Vue.js / Spotify API"/>

        <ProjectCard 
            type='right'
            appName="Weird Web-Site of [Mr. o_O]"
            appUrl="https://mistermisteroo.ru"
            appDescription="Videoblog page"
            fullDescription="A CMS for videos and images."
            footer="Laravel / MySQL" />
        
        <FooterCard />
    </div>
</template>
<script>
export default {
    
}
</script>
