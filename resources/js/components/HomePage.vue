//HomePage
//домашняя страница
<template>
    <div class="row h-100 justify-content-center p-0 m-0">
    
        <!-- карточка с информацией о владельце -->
        <HeaderCard v-if="siteOwnerInfo !== -1"
            :info="siteOwnerInfo"/>
        
        <!-- карточки проектов (выводятся в цикле) -->
        <ProjectCard v-for="project in fullProjectList.home" :key="project.id"
                     :project="project" :type="project.orientation" :isVisible="false"/>

        <!-- другие проекты -->
        <OtherProjectsCard v-if="fullProjectList !== -1 && fullProjectList.other.length > 0" :projects="fullProjectList.other"/>

        <!-- карточка футер -->
        <FooterCard v-if="footer === 1"/>    

    </div>
</template>

<script>
export default {

    created(){
        this.setScreenOrientation();
        window.addEventListener("resize", this.setScreenOrientation);
    },

    computed: {
        //информация о владельце сайта
        siteOwnerInfo: function(){        
             return this.$store.state.GlobalStates.siteOwnerInfo;
        },

        //полный список проектов
        fullProjectList: function(){
            return this.$store.state.GlobalStates.fullProjectList;
        },

        //settings.footer
        footer: function(){
            return this.$parent.settings.footer;
        },
    },

    //методы
    methods: {
        setScreenOrientation(){
            let width = window.innerWidth;
            let height = window.innerHeight;

            if(width > height){
                this.$store.commit('setState', {state: 'screenOrientation', value: 'horizontal'});
            }
            else if (height > width){
                 this.$store.commit('setState', {state: 'screenOrientation', value: 'vertical'});
            }
        }
    }
}
</script>
