//BasicSettings
//общие настройки
<template>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="row justify-content-center">
                <div class="col-12">
                    <!-- форма -->
                    <form method="POST" @submit.prevent="submit">
                        <!-- название сайта -->
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8 mb-3 goUpAnim" v-if="site_title != -1">
                                <h6>Название сайта</h6>
                                <input type="text" class="form-control" placeholder="Название сайта" v-model="site_title">
                                <div v-if="errors && errors.site_title" class="text-danger goUpAnim">{{ errors.site_title[0] }}</div>
                            </div>
                        </div> 
                        <!-- статус сайта - открыт\закрыт -->
                        <div class="row justify-content-center mt-5 goUpAnim" v-if="public_access != -1">
                            <div class="col-12 col-md-8 text-center font14pt form-check">
                                <div class="btn-group col-12 col-md-10" role="group" aria-label="Basic example">
                                    <button type="button" class="btn" 
                                            v-bind:class="{'btn-light': public_access === 1, 'btn-outline-light': public_access === 0}"
                                            v-on:click="togglePublicAccess(1)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="public_access === 1"></i>
                                        Сайт открыт для посетителей
                                    </button>
                                    <button type="button" class="btn"
                                            v-bind:class="{'btn-light': public_access === 0, 'btn-outline-light': public_access === 1}"
                                            v-on:click="togglePublicAccess(0)">
                                        <i class="bi bi-check2 fadeInAnim" v-if="public_access === 0"></i>
                                        Сайт закрыт
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- текст сообщения, если сайт закрыт -->
                        <div class="row justify-content-center mt-3 goUpAnim" v-if="public_access === 0">
                            <div class="col-12 col-md-6 form-floating">
                                <h6>Текст сообщения для посетителей</h6>
                                <textarea class="form-control" placeholder="Например: Сайт закрыт на технические работы" id="floatingTextarea" v-model="public_access_message"></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-center goUpAnim m-5" v-if="site_title != -1">
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
        axios.get('/api/getBasicSettings').then(response => {
            this.site_title = response.data.site_title;
            this.public_access = response.data.public_access;
            this.public_access_message = response.data.public_access_message;
        }).catch(error => {
            this.site_title = false;
        })
    },
    mounted(){
        this.$parent.currentTab = 'basicSettings';
    },

    //данные
    data: () => {
        return {
            //заголовок сайта
            site_title: -1,
            //статус сайта, открыт\закрыт
            public_access: -1,
            //сообщение для посетителей, если закрыт
            public_access_message: -1,
            errors: null,
            saved: false,
            backup: null,
        }
    },

    //методы
    methods: {
        //вкл\выкл доступ к сайту
        togglePublicAccess(value){
            if(this.public_access != value)
            { this.edit = true; }
            this.public_access = value;
        },

        //сохранить
        submit(){
            this.saved = false;
            let formData = new FormData();
            formData.append('site_title', this.site_title);
            formData.append('public_access', this.public_access);
            formData.append('public_access_message', this.public_access_message);
            axios.post('/admin/saveBasicSettings', formData).then(response => {
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