//SiteOwnerInfo
//вкладка в админке, информация о владельце сайта
<template> 
    <div class="row justify-content-center fadeInAnim" v-if="siteOwnerInfo !== -1"> 
        <div class="col-10 p-0">
            <div class="row justify-content-center">
                        <!-- форма редактирования -->
            <div class="mt-2 fadeInAnim" v-bind:class="{'zeroOpacity': siteOwnerInfo === -1,
            'col-12': screenOrientation === 'vertical', 'col-4': screenOrientation === 'horizontal'}">
                <h5>Информация о владельце</h5>
                <hr>
                <form @submit.prevent="submit" method="POST">
                    <!-- имя -->
                    <div class="mb-3">
                        <h6>Имя владельца сайта</h6>
                        <input v-model="siteOwnerInfo.name" type="text" class="form-control" required>
                        <div v-if="errors && errors.name" class="text-danger goUpAnim">{{ errors.name[0] }}</div>
                    </div>
                    <!-- род занятий -->
                    <div class="mb-3">
                        <h6>Род занятий</h6>
                        <input v-model="siteOwnerInfo.occupation" type="text" class="form-control" required>
                        <div v-if="errors && errors.occupation" class="text-danger goUpAnim">{{ errors.occupation[0] }}</div>
                    </div>
                    <!-- о себе -->
                    <div class="mb-3">
                        <h6>Кратко о себе</h6>
                        <textarea v-model="siteOwnerInfo.aboutMe" class="form-control" required></textarea>
                        <div v-if="errors && errors.aboutMe" class="text-danger goUpAnim">{{ errors.aboutMe[0] }}</div>
                    </div>
                    <!-- нижний текст -->
                    <div class="mb-3">
                        <h6>Нижний текст</h6>
                        <input v-model="siteOwnerInfo.bottomText" type="text" class="form-control" required>
                        <div v-if="errors && errors.bottomText" class="text-danger goUpAnim">{{ errors.bottomText[0] }}</div>
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
            <!-- превью -->
            <div class="mt-2 mb-2" v-if="siteOwnerInfo !== -1"
            v-bind:class="{'col-12': screenOrientation === 'vertical', 'col-6': screenOrientation === 'horizontal'}">
                <h5>Превью</h5>
                <hr>
                <PreviewOwner :siteOwnerInfo="siteOwnerInfo"/>
            </div>
            </div>
    
        </div>
 
        
    </div>
</template>
<script>
export default {
    //хуки
    beforeCreate(){
        //текущая вкладка
        this.$parent.currentTab = "headerCard";
        //получить информацию о владельце

            // alert()
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
        //инф-ция о владельце сайта
        siteOwnerInfo: function(){
            return this.$store.state.GlobalStates.siteOwnerInfo;
        },

        screenOrientation: function(){
            return this.$store.state.GlobalStates.screenOrientation;
        }
    },

    //методы
    methods: {
        //сохранить изменения
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