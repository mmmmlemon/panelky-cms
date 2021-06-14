//HomeSettings
//настройки главной страницы
<template>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="row justify-content-center">
                <div class="col-12">
                    <!-- форма -->
                    <form method="POST" @submit.prevent="submit">
                        <h6 class="text-center mb-4 goUpAnim">Отображение элементов на главной странице</h6>
                        <div class="row justify-content-center goUpAnim" v-if="side_nav != -1">
                            <!-- боковое меню -->
                            <div class="col-12 col-md-8 text-center font14pt form-check" v-if="side_nav != -1">
                                <div class="btn-group col-12 col-md-10" role="group" aria-label="Basic example">
                                    <button type="button" class="btn" 
                                            v-bind:class="{'btn-light': side_nav === 1, 'btn-outline-light': side_nav === 0}"
                                            v-on:click="toggleValue('side_nav', 1)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="side_nav === 1"></i>
                                        Боковое меню
                                    </button>
                                    <button type="button" class="btn"
                                            v-bind:class="{'btn-light': side_nav === 0, 'btn-outline-light': side_nav === 1}"
                                            v-on:click="toggleValue('side_nav', 0)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="side_nav === 0"></i>
                                        Без бокового меню
                                    </button>
                                </div>
                            </div>

                            <!-- о себе -->
                            <div class="col-12 col-md-8 text-center font14pt form-check mt-3">
                                <div class="btn-group col-12 col-md-10" role="group" aria-label="Basic example">
                                    <button type="button" class="btn" 
                                            v-bind:class="{'btn-light': about === 1, 'btn-outline-light': about === 0}"
                                            v-on:click="toggleValue('about', 1)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="about=== 1"></i>
                                        Раздел "О сайте"
                                    </button>
                                    <button type="button" class="btn"
                                            v-bind:class="{'btn-light': about === 0, 'btn-outline-light': about === 1}"
                                            v-on:click="toggleValue('about', 0)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="about === 0"></i>
                                        Без раздела "О сайте"
                                    </button>
                                </div>
                            </div>

                            <!-- информация о владельце -->
                            <div class="col-12 col-md-8 text-center font14pt form-check mt-3">
                                <div class="btn-group col-12 col-md-10" role="group" aria-label="Basic example">
                                    <button type="button" class="btn" 
                                            v-bind:class="{'btn-light': site_owner === 1, 'btn-outline-light': site_owner === 0}"
                                            v-on:click="toggleValue('site_owner', 1)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="site_owner === 1"></i>
                                        Карточка приветствия
                                    </button>
                                    <button type="button" class="btn"
                                            v-bind:class="{'btn-light': site_owner === 0, 'btn-outline-light': site_owner === 1}"
                                            v-on:click="toggleValue('site_owner', 0)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="site_owner === 0"></i>
                                        Без карточки приветствия
                                    </button>
                                </div>
                            </div>

                            <!-- проекты -->
                            <div class="col-12 col-md-8 text-center font14pt form-check mt-3">
                                <div class="btn-group col-12 col-md-10" role="group" aria-label="Basic example">
                                    <button type="button" class="btn" 
                                            v-bind:class="{'btn-light': projects === 1, 'btn-outline-light': projects === 0}"
                                            v-on:click="toggleValue('projects', 1)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="projects === 1"></i>
                                        Карточки проектов
                                    </button>
                                    <button type="button" class="btn"
                                            v-bind:class="{'btn-light': projects === 0, 'btn-outline-light': projects === 1}"
                                            v-on:click="toggleValue('projects', 0)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="projects === 0"></i>
                                        Без карточек проектов
                                    </button>
                                </div>
                            </div>

                            <!-- футер -->
                            <div class="col-12 col-md-8 text-center font14pt form-check mt-3">
                                <div class="btn-group col-12 col-md-10" role="group" aria-label="Basic example">
                                    <button type="button" class="btn" 
                                            v-bind:class="{'btn-light': footer === 1, 'btn-outline-light': footer === 0}"
                                            v-on:click="toggleValue('footer', 1)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="footer=== 1"></i>
                                        Ссылки и контакты
                                    </button>
                                    <button type="button" class="btn"
                                            v-bind:class="{'btn-light': footer === 0, 'btn-outline-light': footer === 1}"
                                            v-on:click="toggleValue('footer', 0)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="footer === 0"></i>
                                        Без ссылок и контактов
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Сохранить -->
                        <div class="row justify-content-center goUpAnim m-5" v-if="side_nav != -1">
                            <div class="col-12 col-md-5">
                                <button class="btn btn-outline-light btn-lg btn-block ml-2" title="Сохранить изменения">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- сообщение о сохранении настроек -->
        <div class="col-12 p-1 text-center unclickable zeroOpacity" v-bind:class="{ blinkAnim: saved }">
            <h5>Изменения сохранены</h5>
        </div>
    </div>
</template>
<script>
export default {
    //хуки
    created(){
        //получить настройки
        axios.get('/api/getHomeSettings').then(response => {
            this.side_nav = response.data.side_nav;
            this.about = response.data.about;
            this.site_owner = response.data.site_owner;
            this.projects = response.data.projects;
            this.footer = response.data.footer;
        })
    },

    mounted(){
        this.$parent.currentTab = 'homeSettings';
    },

    //данные
    data: () => {
        return {
            //боковая навигация, вкл\выкл
            side_nav: -1,
            //о сайте, вкл\выкл
            about: 1,
            //карточка приветствия, вкл\выкл
            site_owner: 1,
            //проекты, вкл\выкл
            projects: 1,
            //ссылки и контакты, вкл\выкл
            footer: 1,
            saved: false,
        }
    },

    //методы
    methods: {
        //переключить настройку
        toggleValue(data, value){
            if(data == 'side_nav')
            { this.side_nav = value; }

            if(data == 'about')
            { this.about = value; }

            if(data == 'site_owner')
            { this.site_owner = value; }

            if(data == 'projects')
            { this.projects = value; }

            if(data == 'footer')
            { this.footer = value; }
        },

        //сохранить изменения
        submit(){
            this.saved = false;
            let formData = new FormData();
            formData.append('side_nav', this.side_nav);
            formData.append('about', this.about);
            formData.append('site_owner', this.site_owner);
            formData.append('projects', this.projects);
            formData.append('footer', this.footer);
            axios.post('/admin/saveHomeSettings', formData).then(response => {
                this.saved = true;
                this.errors = null;
            }).catch(error => {
                 if(error.response.status === 422){ 
                        this.errors = error.response.data.errors || {};
                    }
            });
        }   
    }
}
</script>