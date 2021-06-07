//App
//корневой компонент для публичной части сайта
<template>

    <div class="container col-12 vh-100">
        <!-- навигация -->
        <Nav v-if="public_access == 1 && settings.about === 1"/>
        <!-- кнопка навигации в верхнем углу экрана -->
        <NavButton v-if="public_access == 1 && settings.side_nav === 1"/>
        <!-- кнопка "Наверх" -->
        <NavScroll v-if="public_access == 1" :navScrollStyle="navScrollStyle"/>
        
        <!-- пока не загрузился список проектов, не показывать router-view -->
        <router-view v-if="public_access == 1"
                     v-touch:swipe.left="showNavMenu">
        </router-view>

        <div class="row h-100 d-flex text-center justify-content-center goUpAnim" v-if="public_access == 0">
             <div class="textVertical text-center fadeInAnim">
                <h1 class="font2-5rem">Сайт недоступен</h1>
                <hr>
                <i class="bi bi-lock font2-5rem"></i>
                <p v-if="public_access_message !== -1" class="font1-2rem fadeInAnim">{{public_access_message}}</p>
                
                <h4><a href="/">🐍</a></h4>
            </div>
        </div>
    </div>
</template>
<script>
export default {

    //хуки
    created(){
        
        axios.get('/api/getAccessStatus').then(response => {
            this.public_access = response.data;

            if(this.public_access == 0){
                axios.get('/api/getPublicAccessMessage').then(response => {
                    this.public_access_message = response.data;
                });
            }
            else if (this.public_access == 1)
            {    
                axios.get('/api/getHomeSettings').then(response => {
                    this.settings = response.data;

                    if(this.settings.site_owner === 1){
                        //получить информацию о владельце сайта
                        this.$store.dispatch('getSiteOwnerInfo');
                    }
                    
                    if(this.settings.projects === 1){
                        //получение полного списка проектов для HomePage.vue
                        this.$store.dispatch('getFullProjectList'); 
                    }

                });

                //при событии scroll будет срабатывать метод handleNavScroll
                window.addEventListener('scroll', this.handleNavScroll);

              
            }
            });
    },

    destroyed() {
        //убрать listener для события scroll
        window.removeEventListener('scroll', this.handleNavScroll);
    },

    //данные
    data: function(){
        return {
            //стиль для кнопки "Наверх"
            navScrollStyle: undefined,
            //вкл. анимацию для HeaderCard.vue
            startHeaderCardTransition: false,
            //статус сайта
            public_access: -1,
            public_access_message: -1,
            settings: -1,
        }
    },

    computed: {
        //полный список проектов
        fullProjectList: function(){
            return this.$store.state.GlobalStates.fullProjectList;
        },
    },

    //методы
    methods: {
        //показать кнопку NavScroll при скролле вниз
        //или спрятать при скролле вверх
        handleNavScroll(event){
            var height = window.innerHeight;

            if(window.pageYOffset > height + height / 3){ 
                this.navScrollStyle = { opacity: 1, zIndex: '3' }; 
            }
            else if (window.pageYOffset < height + height / 3){ 
                this.navScrollStyle = { opacity: 0, zIndex: '-9999999' }; 
            }
        },

        //показать боковое меню
        showNavMenu: function(){
            if(this.$isMobile){   
                //устанавливаем стиль для NavMenu
                this.$store.dispatch('setNavMenuStyle', {'right':'0px', 'opacity':'1'});
                //отключаем скролл страницы пока открыто меню
                document.body.style.overflow = 'hidden'; 
             }
        },

        //закрыть боковое меню
        closeNavMenu: function(){  
            if(this.$isMobile){
                this.$store.dispatch('setNavMenuStyle', {'right':'-500px', 'opacity':'0'});
                //если сайт открыт на телефоне, возвращаем скролл
                document.body.style.overflow = 'visible'; 
            }
        },
    }
}
</script>