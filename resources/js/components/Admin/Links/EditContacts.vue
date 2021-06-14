//EditContacts
//форма редактирования e-mail
<template>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="row justify-content-center">
                <Error v-if="email === false" errorMessage="Произошла ошибка при получении контактов"/>
                <div class="col-12 goUpAnim" v-if="email !== -1 && email !== false">
                    <!-- форма редактирования имейла -->
                    <form method="POST" @submit.prevent="submit">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-5 mb-3">
                                <h6>E-Mail</h6>
                                <input type="text" class="form-control" placeholder="username@mail.ru" v-on:keydown="toggleEdit(true)" v-model="email">
                                <div v-if="errors && errors.email" class="text-danger goUpAnim">{{ errors.email[0] }}</div>
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
    created(){
        axios.get('/api/getEmail').then(response => {
            this.email = response.data.email;
        }).catch(error => {
            this.email = false;
        })
    },

    mounted(){
        //текущая вкладка в Links.vue
        this.$parent.currentTab = "editContacts";
    },

    //данные
    data: () => {
        return{
            email: -1,
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

        //сохранить email
        submit(){
           let formData = new FormData();
           formData.append('email', this.email);
           axios.post('/admin/editEmail', formData).then(response => {
               this.edit = false;
               this.errors = null;
           }).catch(error => {
               if(error.response.status === 422){ 
                        this.errors = error.response.data.errors || {};
                }
           })

        }
    }
}
</script>