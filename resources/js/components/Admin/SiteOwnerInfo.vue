//SiteOwnerInfo
//вкладка в админке, информация о владельце сайта
<template>
    
        <div class="row justify-content-center"> 

            <!-- форма редактирования -->
            <div class="col-12 col-md-4 mt-5 fadeInAnim" v-bind:class="{zeroOpacity: siteOwnerInfo === -1}">
                <h5>Информация о владельце</h5>
                <hr>
                <form @submit.prevent="submit" method="POST">
                    <div class="mb-3">
                        <h6>Имя владельца сайта</h6>
                        <input v-model="siteOwnerInfo.name" type="text" class="form-control" required>
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>
                    <div class="mb-3">
                        <h6>Род занятий</h6>
                        <input v-model="siteOwnerInfo.occupation" type="text" class="form-control" required>
                        <div v-if="errors && errors.occupation" class="text-danger">{{ errors.occupation[0] }}</div>
                    </div>
                    <div class="mb-3">
                        <h6>Кратко о себе</h6>
                        <textarea v-model="siteOwnerInfo.aboutMe" class="form-control" required></textarea>
                        <div v-if="errors && errors.aboutMe" class="text-danger">{{ errors.aboutMe[0] }}</div>
                    </div>
                    <div class="mb-3">
                        <h6>Нижний текст</h6>
                        <input v-model="siteOwnerInfo.bottomText" type="text" class="form-control" required>
                        <div v-if="errors && errors.bottomText" class="text-danger">{{ errors.bottomText[0] }}</div>
                    </div>

                    <button class="btn btn-lg btn-block btn-outline-light">
                        Сохранить
                    </button>
                </form>
                
                <!-- сообщение о сохранении настроек -->
                <div class="col-12 p-3 text-center unclickable zeroOpacity" v-bind:class="{ blinkAnim: saved }">
                    <h5>Изменения сохранены</h5>
                </div>

            </div>
            <div class="col-md-6 mt-5">
                <h5>Превью</h5>
                <hr>
                <!-- превью -->
                <PreviewOwner :name="siteOwnerInfo.name" :occupation="siteOwnerInfo.occupation" :aboutMe="siteOwnerInfo.aboutMe" :bottomText="siteOwnerInfo.bottomText"/>
            </div>
           
        </div>

</template>
<script>
export default {

    //хуки
    beforeCreate(){
        //текущая вкладка
        this.$store.dispatch('setCurrentTab', 'admin');
        //получить информацию о владельце
        this.$store.dispatch('getSiteOwnerInfo');
    },

    //данные
    data: function(){
        return {
            errors: {},
            saved: false,
        }  
    },

    computed: {
        siteOwnerInfo: function(){
            return this.$store.state.GlobalStates.siteOwnerInfo;
        }
    },

    //методы
    methods: {
        //отправить форму
        submit(){
            this.saved = false;
            this.errors = {};

            axios.post('/admin/saveSiteOwnerInfo', this.siteOwnerInfo).then(response => {
                    this.saved = true;
                }).catch(error => {
                    if(error.response.status === 422){ 
                        this.errors = error.response.data.errors || {};
                    }
                });
        }
    }
}
</script>