//NavButton
//кнопка навигации с боковым меню
<template>
    <transition name="navMenu">
        <div v-if="visible === true">
            <!-- кнопка меню -->
            <!-- видна только на десктопе -->
            <button v-on:click="showNavMenu()" class="d-block navButton zIndex3 fadeInAnim">
                <i class="d-none d-md-block bi bi-three-dots-vertical"></i>
                <i class="d-block d-md-none bi bi-three-dots"></i>
            </button>
            
            <!-- меню -->
            <div class="navMenu" :style="{right: navMenuStyle['right'], opacity: navMenuStyle['opacity'], zIndex: z}"
                v-bind:class="{'col-12': screenOrientation === 'vertical', 'col-2': screenOrientation === 'horizontal'}">
                <div class="row justify-content-end" v-if="fullProjectList !== undefined">
                    <!-- кнопка закрыть меню -->
                    <button class="navButtonClose" v-on:click="closeNavMenu()">
                        <i class="bi bi-x"></i>
                    </button>
                    <!-- пункты меню -->
                    <!-- главная -->
                    <div class="col-12" v-if="about ===  1">
                        <h6 class="text-center">
                            <router-link to="/"><b @click="closeNavMenu()">Главная</b></router-link>
                        </h6>
                        <hr>
                    </div>
                    <!-- проекты -->
                    <div class="col-12" v-if="fullProjectList != -1 && fullProjectList.home !== false">
                        <h6 class="text-center">
                            <b>Проекты</b>
                        </h6>
                        <hr>
                    </div>
                    <!-- список проектов -->
                    <div v-for="(project, index) in fullProjectList.home" :key="project.slug" class="col-12 text-center">
                        <h6 class="m-0" v-bind:class="{'mt-4': index > 0}">
                            <a v-on:click="closeNavMenu()" :href="`#${project.slug}`">{{project.project_title}}</a>
                        </h6>
                    </div>
                    <div class="col-12 mt-4" v-if="fullProjectList !== -1 && fullProjectList.other.length > 0">
                        <h6 class="text-center">
                            <a v-on:click="closeNavMenu()" :href="`#other`">Другие проекты</a>
                        </h6>
                        <hr>
                    </div>
                    <!-- ссылки -->
                    <div class="col-12" v-if="links !== false && links != -1">
                        <hr v-if="fullProjectList !== -1 && fullProjectList.other.length === 0">
                        <h6 class="text-center">
                            <a href="/#links" v-on:click="closeNavMenu()">
                                <b>Ссылки</b>
                            </a>
                        </h6>
                        <hr>
                    </div>
                    <!-- список ссылок -->
                    <div class="d-none col-12 text-center" v-if="links !== false && links !== -1">
                        <h6 v-for="(link, index) in links" :key="link.slug" class="mb-3" v-bind:class="{'invisible': index > 2}">
                            <a v-on:click="closeNavMenu()" target="_blank" :href="link.link_url">
                                {{link.link_title}}
                            </a>
                        </h6>
                        <hr>
                    </div>
                    <!-- контакты -->
                    <div class="col-12" v-if="links !== false && links != -1">
                        <h6 class="text-center mb-3">
                            <a v-on:click="closeNavMenu()" href="#contacts"><b>Контакты</b></a>
                        </h6>
                        <hr v-if="order === 1 || about === 1">
                    </div>
                    <!-- заказать проект -->
                    <div class="col-12" v-if="order ===  1">
                        <h6 class="text-center">
                            <router-link to="/requestProject"><b @click="closeNavMenu()">Заказать проект</b></router-link>
                        </h6>
                         <hr v-if="about === 1">
                    </div>
                    <!-- о сайте -->
                    <div class="col-12" v-if="about ===  1">
                        <h6 class="text-center">
                            <router-link to="/about"><b @click="closeNavMenu()">О сайте</b></router-link>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<script>
    export default {
        data: () => {
            return {
                z: -9999,
            }
        },
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
            },
            screenOrientation: function(){
                return this.$store.state.GlobalStates.screenOrientation;
            },
            order(){
                return this.$parent.settings.order;
            },
            about: function(){
                return this.$parent.settings.about;
            },

            visible: function(){
                // let currentTab = this.$parent.currentTab;
                // switch(currentTab){
                //     case 'home':
                //         return true;
                //     case 'about':
                //         return true;
                //     case 'requestProject':
                //         return true;
                // }

                return true;
            }
        },

        //методы
        methods: {
            //показать боковое меню
            showNavMenu: function() {
                this.$store.dispatch('setNavMenuStyle', {'right':'0px', 'opacity':'1'});
                this.z = 7;
                // если сайт открыт на телефоне, то отключаем скролл страницы
                //пока открыто меню
                if(this.$isMobile)
                { document.body.style.overflow = 'hidden'; }
            },

            //закрыть боковое меню
            closeNavMenu: function() {
                this.$store.dispatch('setNavMenuStyle', {'right':'-500px', 'opacity':'0'});
                this.z = -9999;
                //если сайт открыт на телефоне, возвращаем скролл
                if(this.$isMobile)
                { document.body.style.overflow = 'visible'; }
            }
        }
    }
</script>