// CookiesSettings
// настройки кукисов

<template>
    <div class="row justify-content-center fadeInAnim">
        <div class="col-10 p-0">
            <div class="row justify-content-center">
                <!-- форма редактирования -->
                <div class="col-12 col-md-10 mt-2 fadeInAnim" v-if="cookiesMessage !== false && cookiesMessage !== undefined">
                    <h5>Предупреждение о Cookies</h5>
                    <hr>
                    <!-- о себе -->
                    <div class="mb-3">
                        <vue-editor style="background-color: white; color: black;" v-model="cookiesMessage"/>
                    </div>
                    <button class="btn btn-lg btn-block btn-outline-light" @click="submit">
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
    mounted(){
        this.$parent.currentTab = 'cookies';

        axios.get('/admin/getCookiesMessage').then(response => {
            this.cookiesMessage = response.data;
        });

    },

    //данные
    data: function(){
        return {
            errors: {},
            saved: false,
            cookiesMessage: undefined,
        }  
    },

    computed: {
        settings(){
            return this.$store.state.GlobalStates.settings;
        },
    },

    methods: {
        submit(){
            let formData = new FormData();
            formData.append('cookiesMessage', this.cookiesMessage);
            this.saved = false;
            axios.post('/admin/saveCookiesMessage', formData).then(response => {
                this.saved = true;
            })

        }
    }
}
</script>