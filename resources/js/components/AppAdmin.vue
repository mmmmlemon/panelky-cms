// AppAdmin
// корневой компонент для админки

<template>
    <div class="container col-12 vh-100">
   
        <div class="col-12 text-center mt-5">
            <h4>Панель администратора</h4>
            <hr>
        </div>
        <div class="row mb-5">
            <div class="col-12 col-md-4 mb-3">
                <h6 class="text-right">
                    <a href="/">
                        На главную <i class="bi bi-house"></i>
                    </a>
                </h6>
            </div>
            <div class="col-12 col-md-4">
                <h6 class="text-right" v-on:click.prevent="logout">
                    <a href="#exit">
                        Выйти <i class="bi bi-box-arrow-right"></i>
                    </a>
                </h6>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-8 ">
                <ul class="nav nav-fill">
                    <li class="nav-item mr-2">
                        <router-link to="/admin" class="btn btn-block btn-light font14pt" aria-current="page">Владелец сайта</router-link>
                    </li>
                    <li class="nav-item mr-2">
                        <router-link to="/admin/projects" class="btn btn-block btn-outline-light font14pt">Проекты</router-link>
                    </li>
                    <li class="nav-item mr-2">
                        <router-link to="/admin/links" class="btn btn-block btn-outline-light font14pt">Ссылки и контакты</router-link>
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
    
    data: function() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }   
    },

    methods: {
        logout: function(){
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