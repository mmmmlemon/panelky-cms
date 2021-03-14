// NavButton
// кнопка навигации с боковым меню
<template>
<div style="background-color: red; position: fixed; heigth: 100%;">
    <!-- кнопка меню - десктоп-->
    <button style="z-index: 3;" class="d-none d-md-block btn navButton" @click="showNavMenu()">
        <i class="bi bi-three-dots-vertical" style="font-size: 1.5rem; color: white;"></i>
    </button>

    <!-- меню -->
    <div class="col-12 col-md-2 navMenu" :style="{right: navMenuStyle['right'], opacity: navMenuStyle['opacity'], zIndex: 4}">
        <div class="row justify-content-end">
            <!-- кнопка закрыть меню -->
            <button class="btn" v-on:click="closeNavMenu()">
                <i class="bi bi-x" style="font-size: 1.5rem;"></i>
            </button>
            <!-- пункты меню -->
            <div class="col-12">
                <!-- проекты -->
                <h6 class="text-center">
                    <b>Projects</b>
                </h6>
                <hr class="blackHR">
            </div>
            <div class="col-12 text-center">
                <h6>
                    <a href="#spotifyi" @click="closeNavMenu()">SpotiFYI</a>
                </h6>
                <br>
                <h6>Weird Web-Site of [Mr. o_O]</h6>
                <br>
                <h6>Panelky</h6>
                <hr class="blackHR">
                <!-- ссылки -->
                <h6>Links</h6>
            </div>
        </div>
    </div>
</div>
</template>

<script>

export default {
    
    data: function() {
        return {
            navMenuRight: '-500px',
            navMenuOpacity: '0',
        }     
    },

    computed:{
        navMenuStyle: function(){
            return this.$store.state.GlobalStates.navMenuStyle;
        }
    },

    methods: {
        // показать боковое меню
        showNavMenu: function() {
            this.$store.dispatch('setNavMenuStyle', {'right':'0px', 'opacity':'1'});
            // если сайт открыт на телефоне, то отключаем скролл страницы
            //пока открыто меню
            if(this.$isMobile)
            { document.body.style.overflow = 'hidden'; }
        },

        //закрыть боковое меню
        closeNavMenu: function() {
            this.$store.dispatch('setNavMenuStyle', {'right':'-500px', 'opacity':'0'});
            //если сайт открыт на телефоне, возвращаем скролл
            if(this.$isMobile)
            { document.body.style.overflow = 'visible'; }
        }
    }
}
</script>