//AppAdmin
//корневой компонент для админки
<template>
    <div class="container col-12 vh-100">
        
        <!-- ошибки -->
        <div class="col-3" style="position: fixed; z-index: 3;" v-if="errors !== -1">
            <button class="btn btn-sm btn-danger mb-1 goUpAnim" v-on:click="clearError">
                X
            </button>
            <Error :errorMessage="errors"/>
        </div>
        <!-- модальное окно для удаления проектов -->
        <DeleteModal />

        <div class="col-12 text-center mt-5">
            <h4>Панель администратора</h4>
            <hr>
        </div>
        
        <div class="row mb-5">
            <!-- ссылка на главную страницу -->
            <div class="col-12 col-md-4 mb-3">
                <h6 class="text-right">
                    <a href="/">
                        На главную <i class="bi bi-house"></i>
                    </a>
                </h6>
            </div>
            <!-- ссылка на logout -->
            <div class="col-12 col-md-4">
                <h6 class="text-right" v-on:click.prevent="logout">
                    <a href="#exit">
                        Выйти <i class="bi bi-box-arrow-right"></i>
                    </a>
                </h6>
            </div>
        </div>

        <!-- меню админки -->
        <div class="row justify-content-center">
            <div class="col-8 ">
                <ul class="nav nav-fill">
                    <!-- Владлец сайта -->
                    <li class="nav-item mr-2">
                        <router-link v-bind:class="{'btn-light': currentTab === 'admin', 
                                                    'btn-outline-light': currentTab !== 'admin'}"
                                                    to="/admin" class="btn btn-block font14pt" aria-current="page">
                            Владелец сайта
                        </router-link>
                    </li>
                    <!-- Проекты -->
                    <li class="nav-item mr-2">
                        <router-link v-bind:class="{'btn-light': currentTab === 'projects', 
                                                    'btn-outline-light': currentTab !== 'projects'}"
                                                    to="/admin/projects" class="btn btn-block font14pt" >
                            Проекты
                        </router-link>
                    </li>
                    <!-- Ссылки и контакты -->
                    <li class="nav-item mr-2">
                        <router-link v-bind:class="{'btn-light': currentTab === 'links', 
                                                    'btn-outline-light': currentTab !== 'links'}" 
                                                    to="/admin/links" class="btn btn-block font14pt">
                            Ссылки и контакты
                        </router-link>
                    </li>
                    <!-- Настройки сайта -->
                    <li class="nav-item mr-2">
                        <router-link v-bind:class="{'btn-light': currentTab === 'settings', 
                                                    'btn-outline-light': currentTab !== 'settings'}" 
                                                    to="/admin/settings" class="btn btn-block font14pt">
                            Настройки
                        </router-link>
                    </li>
                </ul>
            </div>
            <div class="col-12">
                <router-view></router-view>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    //хуки
    created(){
        this.$store.dispatch('getAnimatedBackground');
    },

    //данные
    data: function() {
        return {
            //CSRF-токен
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }   
    },

    computed: {
        //текущая открытая вкладка
        currentTab: function() {
            return this.$store.state.AdminStates.currentTab;
        },

        //ошибки
        errors: function(){
            return this.$store.state.AdminStates.errors;
        }
    },

    //методы
    methods: {
        //очистить ошибки
        clearError()
        {
            this.$store.dispatch('setErrors', -1);
        },
        //логаут
        logout: function(){
            //отправить POST-запрос на выход из профиля и перенаправить на главную страницу
            axios.post('logout').then(response => {
                if(response.status === 302 || 401){
                    window.location.href="/";
                }
                else {
                    console.error("Couldn't log out!")
                }
            }).catch(error => {

            });
        },
    },
   
}
</script>