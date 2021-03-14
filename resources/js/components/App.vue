// App
// главный компонент

<template>
    <div class="container col-12 vh-100">
        <Nav />
        <NavButton />
        <router-view 
            v-touch:swipe.left="showNavMenu">
        </router-view>
    </div>
</template>
<script>
export default {
    methods: {
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