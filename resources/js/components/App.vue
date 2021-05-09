// App
// корневой компонент для публичной части сайта


<template>
    <div class="container col-12 vh-100">
        <Nav />
        <NavButton />
        <NavScroll :navScrollStyle="navScrollStyle"/>
        <router-view v-if="fullProjectList !== -1"
            v-touch:swipe.left="showNavMenu">
        </router-view>
    </div>

</template>

<script>
export default {

    created(){
        window.addEventListener('scroll', this.handleNavScroll);
        this.$store.dispatch('getFullProjectList');
    },

    destroyed() {
        window.removeEventListener('scroll', this.handleNavScroll);
    },

    data: function(){
        return {
            navScrollStyle: undefined,
        }
    },

    computed: {
        fullProjectList: function(){
            return this.$store.state.GlobalStates.fullProjectList;
        },
    },

    methods: {
        //показать кнопку NavScroll при скролле вниз
        //или спрятать при скролле вверх
        handleNavScroll(event){

            var height = window.innerHeight;

            if(window.pageYOffset > height + height / 3)
            {
                this.navScrollStyle = { opacity: 1, zIndex: '3' };
            }
            else if (window.pageYOffset < height + height / 3)
            {
                this.navScrollStyle = { opacity: 0, zIndex: '-9999999' };
            }
        },

        // показать боковое меню
        showNavMenu: function() {
            if(this.$isMobile)
            {
                this.$store.dispatch('setNavMenuStyle', {'right':'0px', 'opacity':'1'});
                //отключаем скролл страницы
                //пока открыто меню
                document.body.style.overflow = 'hidden'; 
             }
        },

        //закрыть боковое меню
        closeNavMenu: function() 
        {   
            if(this.$isMobile)
            {
                this.$store.dispatch('setNavMenuStyle', {'right':'-500px', 'opacity':'0'});
                //если сайт открыт на телефоне, возвращаем скролл
                document.body.style.overflow = 'visible'; 
            }
        }
    }
}
</script>