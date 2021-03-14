//HomePage
//домашняя страница
<template>
    <div style="height:100%;" class="row justify-content-center">

        <HeaderCard 
            myName="Egor Zhuravskiy"
            myOccupation="PHP, JavaScript & Python developer"
            aboutMe="High quality web projectlications for you and your family and your pet parrot 🦜 (squawk squawk)"
            footerText="Here are some of my projects"/>

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

}
</script>
