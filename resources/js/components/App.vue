//App
//корневой компонент для публичной части сайта
<template>

    <div class="container col-12 vh-100">
        <!-- навигация -->
        <Nav v-if="public_access == 1 && (settings.about === 1 || settings.order === 1) && isMobile === false && screenOrientation === 'horizontal'"/>
        <!-- кнопка навигации в верхнем углу экрана -->
        <NavButton v-if="public_access == 1 && settings.side_nav === 1 && (isMobile && screenOrientation === 'horizontal') === false"/>
        <!-- кнопка "Наверх" -->
        <NavScroll v-if="public_access == 1" :navScrollStyle="navScrollStyle"/>

        <Cookies v-if="settings.cookies === 1" :cookiesMessage="settings.cookies_message"/>

        <!-- пока не загрузился список проектов, не показывать router-view -->

        <router-view v-if="public_access == 1 && (isMobile && screenOrientation === 'horizontal') === false">
        </router-view>
        <div v-else-if="isMobile && screenOrientation === 'horizontal' && public_access == 1" 
            class="row h-100 d-flex text-center justify-content-center goUpAnim m-1">
            <div class="textVertical text-center fadeInAnim">
                <h1 class="font2-5rem">Внимание!</h1>
                <hr>
                <i class="bi bi-phone font2-5rem"></i>
                <p class="font1-2rem fadeInAnim">Переверните телефон в вертикальное положение</p>
                
                <h4>Спасибо! 👌</h4>

            </div>
        </div>
        
        <!-- сообщение - сайт недоступен -->
        <div class="row h-100 d-flex text-center justify-content-center goUpAnim m-1" v-if="public_access == 0">
             <div class="textVertical text-center fadeInAnim">
                <h1 class="font2-5rem" v-if="public_access_message !== -1">Сайт недоступен</h1>
                <hr v-if="public_access_message !== -1">
                <i class="bi bi-lock font2-5rem"></i>
                <p v-if="public_access_message !== -1" class="font1-2rem fadeInAnim">{{public_access_message}}</p>
                
                <!-- <h4><a href="/">🐍</a></h4> -->
            </div>
        </div>
    </div>

</template>
<script>
export default {
    //хуки
    created(){
        
        this.setScreenOrientation();
        window.addEventListener("resize", this.setScreenOrientation);
        //проверяем статус сайта
        axios.get('/api/getAccessStatus').then(response => {
            this.public_access = response.data;

            //если сайт закрыт для посетителей
            if(this.public_access == 0){
                axios.get('/api/getPublicAccessMessage').then(response => {
                    this.public_access_message = response.data;
                });
            }
            //если сайт открыт
            else if(this.public_access == 1)
            {    
                //получаем настройки главной страницы
                axios.get('/api/getHomeSettings').then(response => {
                    this.settings = response.data;
                    axios.get('/api/checkCookies').then(response => {  
                        if(response.data === true){
                            this.settings.cookies = 0;
                        }
                    });
                    //если нужно показать карточку о владельце сайта, то получаем информацию о владельце

                    if(this.settings.order === 1){
                        this.$store.dispatch('getOrderTypesInfo');
                    }

                    if(this.settings.site_owner === 1){
                        //получить информацию о владельце сайта
                        this.$store.dispatch('getSiteOwnerInfo');
                    }
                    
                    //если показываем проекты, то получаем список проектов
                    if(this.settings.projects === 1){
                        this.$store.dispatch('getFullProjectList'); 
                    }
                });

                //при событии scroll будет срабатывать метод handleNavScroll
                //чтобы отображалась кнопка "Наверх"
                window.addEventListener('scroll', this.handleNavScroll);
            }
            });
    },

    destroyed() {
        //убрать listener для события scroll при уничтожении компонента
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
            //сообщение если сайт недоступен
            public_access_message: -1,
            //настройки главной страницы
            settings: -1,
            currentTab: null,
        }
    },

    computed: {
        //полный список проектов
        fullProjectList: function(){
            return this.$store.state.GlobalStates.fullProjectList;
        },

        screenOrientation: function(){
            return this.$store.state.GlobalStates.screenOrientation;
        },

        isMobile(){
            return this.$isMobileOnly;
        }
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
            if(this.settings.side_nav !== 0)
            {
                if(this.$isMobile)
                {   
                    //устанавливаем стиль для NavMenu
                    this.$store.dispatch('setNavMenuStyle', {'right':'0px', 'opacity':'1'});
                    //отключаем скролл страницы пока открыто меню
                    document.body.style.overflow = 'hidden'; 
                }
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