// NavButton
// кнопка навигации
<template>
<div style="z-index: 2;">
    <!-- кнопка меню -->
    <button class="btn navButton" @click="showNavMenu()">
        <i class="bi bi-three-dots-vertical" style="font-size: 1.5rem; color: white;"></i>
    </button>
    <!-- меню -->
    <div class="col-12 col-md-2 navMenu" :style="{right: navMenuRight, opacity: navMenuOpacity}">
        <div class="row justify-content-end">
            <!-- кнопка закрыть меню -->
            <button class="btn" v-on:click="closeNavMenu()">
                <i class="bi bi-x" style="font-size: 1.5rem;"></i>
            </button>
            <!-- пункты меню -->
            <div class="col-12">
                <br>
                <!-- проекты -->
                <h6 class="text-center"><b>Projects</b></h6>
                <hr class="blackHR">
            </div>
            <div class="col-12 text-center">
                <h6><a href="#spotifyi" class="blackA" @click="closeNavMenu()">SpotiFYI</a></h6>
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

    methods: {
        // показать боковое меню
        showNavMenu: function() {
            this.navMenuRight = '0px';
            this.navMenuOpacity = '1';
            // если сайт открыт на телефоне, то отключаем скролл страницы
            //пока открыто меню
            if(this.$isMobile)
            { document.body.style.overflow = 'hidden'; }
        },

        //закрыть боковое меню
        closeNavMenu: function() {
            this.navMenuOpacity = '0';
            this.navMenuRight = '-500px';
            //если сайт открыт на телефоне, возвращаем скролл
            if(this.$isMobile)
            { document.body.style.overflow = 'visible'; }
        }
    }
}
</script>