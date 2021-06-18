//NavButton
//кнопка навигации с боковым меню
<template>
    <div v-if="links != -1 && links != false || fullProjectList != -1 && fullProjectList != false">

        <!-- кнопка меню -->
        <!-- видна только на десктопе -->
        <button v-on:click="showNavMenu()" class="d-none d-md-block navButton zIndex3 fadeInAnim">
            <i class="bi bi-three-dots-vertical"></i>
        </button>
        
        <!-- меню -->
        <div class="col-12 col-md-2 navMenu" :style="{right: navMenuStyle['right'], opacity: navMenuStyle['opacity'], zIndex: 5}">
            <div class="row justify-content-end" v-if="fullProjectList !== undefined">
                <!-- кнопка закрыть меню -->
                <button class="navButtonClose" v-on:click="closeNavMenu()">
                    <i class="bi bi-x"></i>
                </button>
                <!-- пункты меню -->
                <!-- проекты -->
                <div class="col-12" v-if="fullProjectList != -1 && fullProjectList.home !== false">
                    <h6 class="text-center">
                        <b>Проекты</b>
                    </h6>
                    <hr>
                </div>
                <!-- список проектов -->
                <div v-for="project in fullProjectList.home" :key="project.slug" class="col-12 text-center">
                    <h6>
                        <a v-on:click="closeNavMenu()" :href="`#${project.slug}`">{{project.project_title}}</a>
                    </h6>
                    <br>
                </div>
                <div class="col-12 text-center" v-if="fullProjectList !== -1 && fullProjectList.other.length > 0">
                    <h6>
                        <a v-on:click="closeNavMenu()" :href="`#other`">Другие проекты</a>
                    </h6>
                    <hr>
                </div>
                <!-- ссылки -->
                <div class="col-12" v-if="links !== false && links != -1">
                    <h6 class="text-center">
                        <a href="#links" v-on:click="closeNavMenu()">
                            <b>Ссылки</b>
                        </a>
                    </h6>
                    <hr>
                </div>
                <!-- список ссылок -->
                <div class="col-12 text-center" v-if="links !== false && links !== -1">
                    <h6 v-for="(link, index) in links" :key="link.slug" class="mb-3" v-bind:class="{'invisible': index > 2}">
                        <a v-on:click="closeNavMenu()" target="_blank" :href="link.link_url">
                            {{link.link_title}}
                        </a>
                    </h6>
                    <hr>
                </div>
                <!-- ссылки -->
                <div class="col-12" v-if="links !== false && links != -1">
                    <h6 class="text-center">
                        <a v-on:click="closeNavMenu()" href="#contacts"><b>Контакты</b></a>
                    </h6>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        //данные
        computed:{
            //стиль бокового меню
            navMenuStyle: function(){
                return this.$store.state.GlobalStates.navMenuStyle;
            },
            //список проектов
            fullProjectList: function(){
                return this.$store.state.GlobalStates.fullProjectList;
            },
            //ссылки
            links: function(){
                return this.$store.state.GlobalStates.links;
            }
        },

        //методы
        methods: {
            //показать боковое меню
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