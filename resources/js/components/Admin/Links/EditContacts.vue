//EditContacts
//форма редактирования e-mail
<template>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="row">
                <div class="col-12 goUpAnim">
                    <!-- форма редактирования имейла -->
                    <form method="POST">
                        <div class="row justify-content-center">
                            <div class="col-5 mb-3">
                                <h6>E-Mail</h6>
                                <input type="text" class="form-control" placeholder="username@mail.ru" v-on:keydown="toggleEdit(true)" v-model="email" required>
                                <!-- <div v-if="errors && errors.link_title" class="text-danger goUpAnim">{{ errors.link_title[0] }}</div> -->
                            </div>
                        </div> 
                        <div class="row justify-content-center goUpAnim" v-if="edit === true">
                            <button class="btn btn-light" title="Отмена" v-on:click="toggleEdit(false)">
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
    </div>
</template>
<script>
export default {
    //хуки
    mounted(){
        //текущая вкладка в Links.vue
        this.$parent.currentTab = "editContacts";
    },

    //данные
    data: () => {
        return{
            email: 'zhmyhalo@mail.ru',
            edit: false,
            backup: null,
            errors: null,
        }
    },

    //методы
    methods: {
        //вкл\выкл режим редактирования
        toggleEdit(value){
            if(value === true){
                 if(this.edit === false){ 
                    this.backup = this.email;
                }
                this.edit = true;
            }

            if(value === false){ 
                this.edit = value;
                this.errors = null;
                this.email = this.backup;
            }
        },
    }
}
</script>