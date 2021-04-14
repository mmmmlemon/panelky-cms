// NavButton
// кнопка навигации с боковым меню
<template>

    <div>
        <!-- кнопка меню - десктоп-->
        <button v-on:click="showNavMenu()" class="d-none d-md-block navButton zIndex3">
            <i class="bi bi-three-dots-vertical"></i>
        </button>
        
        <!-- меню -->
        <div class="col-12 col-md-2 navMenu" :style="{right: navMenuStyle['right'], opacity: navMenuStyle['opacity'], zIndex: 5}">
            <div class="row justify-content-end">
                <!-- кнопка закрыть меню -->
                <button class="navButtonClose" v-on:click="closeNavMenu()">
                    <i class="bi bi-x"></i>
                </button>
                <!-- пункты меню -->
                <!-- проекты -->
                <div class="col-12">
                    <h6 class="text-center">
                        <b>Projects</b>
                    </h6>
                    <hr>
                </div>
                <!-- список проектов -->
                <div class="col-12 text-center">
                    <h6>
                        <a v-on:click="closeNavMenu()" href="#spotifyi">SpotiFYI</a>
                    </h6>
                    <br>
                    <h6>Weird Web-Site of [Mr. o_O]</h6>
                    <br>
                    <h6>Panelky</h6>
                    <hr>
                </div>
                <!-- ссылки -->
                <div class="col-12">
                    <h6 class="text-center">
                        <b>Links</b>
                    </h6>
                    <hr>
                </div>
                <!-- список ссылок -->
                <div class="col-12 text-center">
                    <h6>
                        <a v-on:click="closeNavMenu()" href="#spotifyi">GitHub</a>
                    </h6>
                    <br>
                    <h6>KoFi</h6>
                    <br>
                    <h6>Instagramio</h6>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

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