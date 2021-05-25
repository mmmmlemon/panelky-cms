//HomePage
//домашняя страница
<template>
    <div class="row h-100 justify-content-center">
    
        <!-- карточка с информацией о владельце -->
        <HeaderCard 
            :info="siteOwnerInfo"/>
        
        <!-- карточки проектов (выводятся в цикле) -->
        <ProjectCard v-for="project in fullProjectList.home" :key="project.id"
                     :project="project"/>

        <!-- другие проекты -->
        <OtherProjectsCard v-if="fullProjectList !== -1 && fullProjectList.other.length > 0" :projects="fullProjectList.other"/>

        <!-- карточка футер -->
        <FooterCard />
        
    </div>
</template>

<script>
export default {
    //хуки
    created(){
        //получить информацию о владельце сайта
        this.$store.dispatch('getSiteOwnerInfo');
    },

    //данные
    computed: {
        //информация о владельце сайта
        siteOwnerInfo: function(){        
             return this.$store.state.GlobalStates.siteOwnerInfo;
        },

        //полный список проектов
        fullProjectList: function(){
            return this.$store.state.GlobalStates.fullProjectList;
        }
    }
}
</script>
