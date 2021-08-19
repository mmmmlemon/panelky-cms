//SiteOwnerAbout.vue
//О сайте, настройки
<template>
    <div class="row justify-content-center fadeInAnim" v-if="aboutSiteText !== undefined"> 
        <div class="col-10 p-0">
            <div class="row justify-content-center">

            <div class="col-12 col-md-10 mt-2 fadeInAnim" v-if="aboutSiteText == false">
                <Error errorMessage="Не удалось загрузить текст"/>
            </div>

            <!-- форма редактирования -->
            <div class="col-12 col-md-10 mt-2 fadeInAnim" v-if="aboutSiteText !== false">
                <h5>О сайте</h5>
                <hr>
                <!-- о себе -->
                <div class="mb-3">
                    <vue-editor style="background-color: white; color: black;" v-model="aboutSiteText"/>
                    <!-- <div v-if="errors && errors.aboutMe" class="text-danger goUpAnim">{{ errors.aboutMe[0] }}</div> -->
                </div>
                <button class="btn btn-lg btn-block btn-outline-light" v-on:click="submit">
                    Сохранить
                </button>

                <!-- сообщение о сохранении настроек -->
                <div class="col-12 p-3 text-center unclickable zeroOpacity" v-bind:class="{ blinkAnim: saved }">
                    <h5>Изменения сохранены</h5>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    //хуки
    created(){
        this.$parent.currentTab = "about";

        axios.get('/api/getAboutSiteText').then(response => {
            this.aboutSiteText = response.data;
        }).catch(error => {
            this.aboutSiteText = false;
        });

    },

    //данные
    data: function(){
        return {
            errors: {},
            saved: false,
            aboutSiteText: undefined,
        }  
    },

    methods: {
        //отправить форму
        submit(){
            this.saved = false;
            let formData = new FormData();

            formData.append('about_site_text', this.aboutSiteText);

            axios.post('/admin/saveAboutSiteText', formData).then(response => {
                this.saved = true;
            }).catch(error => {
                //
            })
        }   
    }

}
</script>