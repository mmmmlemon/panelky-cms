//BasicSettings
//общие настройки
<template>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="row justify-content-center">
                <div class="col-12">
                    <form method="POST" @submit.prevent="submit">
                        <div class="row justify-content-center">
                            <div class="col-8 mb-3 goUpAnim" v-if="site_title != -1">
                                <h6>Название сайта</h6>
                                <input type="text" class="form-control" placeholder="Название сайта" v-model="site_title" v-on:keydown="toggleEdit(true)">
                                <div v-if="errors && errors.site_title" class="text-danger goUpAnim">{{ errors.site_title[0] }}</div>
                            </div>
                        </div> 
                        <div class="row justify-content-center goUpAnim" v-if="edit === true">
                            <button class="btn btn-light " title="Отмена" v-on:click="toggleEdit(false)">
                                <i class="bi bi-x"></i>
                                Отмена
                            </button>
                            <button class="btn btn-light ml-2" title="Сохранить изменения">
                                <i class="bi bi-save"></i>
                                Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- сообщение о сохранении настроек -->
        <div class="col-12 p-3 text-center unclickable zeroOpacity" v-bind:class="{ blinkAnim: saved }">
            <h5>Изменения сохранены</h5>
        </div>
    </div>
</template>
<script>
export default {
    //хуки
    created(){
        axios.get('/api/getBasicSettings').then(response => {
            this.site_title = response.data.site_title;
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
            site_title: -1,
            errors: null,
            saved: false,
            edit: false,
            backup: null,
        }
    },

    //методы
    methods: {
        //вкл\выкл режим редактирования
        toggleEdit(value){
            if(value === true){
                if(this.edit === false){ 
                    this.backup = {'site_title': this.site_title};
                    this.edit = true;
                }
                else
                { this.edit = true; }
            
            }

            if(value === false){ 
                this.edit = value;
                this.errors = null;
                this.site_title = this.backup.site_title;
            }
        },

        //сохранить
        submit(){
            this.saved = false;
            let formData = new FormData();
            formData.append('site_title', this.site_title);
            axios.post('/admin/saveBasicSettings', formData).then(response => {
                this.edit = false;
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