//EditContacts
//форма редактирования e-mail
<template>
    <div class="row justify-content-center mb-5">
        <!-- кнопки -->
        <div class="col-12 col-md-10 mt-2">
            <button class="btn btn-light fadeInAnim" title="Добавить ссылку" 
                    v-on:click="toggleAddNewContact" v-bind:class="{ 'invisible': addNewContact === true   }">
                <i class="bi bi-plus"></i>
                Добавить контакт
            </button>
            
            <button class="btn btn-light" title="Добавить ссылку" 
                    v-on:click="toggleAddNewContact('back')" v-bind:class="{ 'invisible': addNewContact === false }">
                <i class="bi bi-arrow-left"></i>
                Назад
            </button>
        </div>
        
        <!-- ФОРМА добавить новый контакт -->
        <div class="col-12 col-md-10 mt-5 goUpAnim" v-bind:class="{ 'invisible': addNewContact === false }">
            <form method="POST" @submit.prevent="submit()">
                <div class="row justify-content-center">
                    <!-- иконка соц.сети -->
                    <div class="col-12 col-md-2 text-center" v-html="iconClass">   
                    </div>
                    <!-- список соц. сетей на выбор -->
                    <div class="col-md-3 text-center">
                        <div class="dropdown">
                        <h6>&nbsp;</h6>
                            <button class="btn btn-light btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b v-if="pickedSocialMedia != undefined">{{pickedSocialMedia.tooltip}}</b>
                                <b v-else>Сервис</b>
                            </button>
                            <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                <a v-for="(socialMedia, index) in socialMediaLibrary" 
                                    v-bind:key="index" class="dropdown-item pointer"
                                    @click="pickSocialMedia(index)">
                                    {{socialMedia.tooltip}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- поле для email/юзернейма в соц.сети или номера телефона -->
                    <div class="col-12 col-md-4 mb-3">
                        <h6 v-html="tooltipTitle"></h6>
                        <input type="text" class="form-control" v-model="newContact.contact_url" required>
                        <div v-if="errors && errors.contact_url" class="text-danger goUpAnim">{{ errors.contact_url[0]}}</div>
                        <a v-if="socialMediaGeneratedLink !== undefined && newContact.contact_url !== undefined" 
                            :href="socialMediaGeneratedLink"
                            target="_blank" class="goUpAnim">
                            Проверить ссылку
                        </a>
                    </div>
                    <!-- кнопка добавить контакт -->
                    <div class="col-12 col-md-3 mb-3">
                        <h6>&nbsp;</h6>
                        <button class="btn btn-light ml-2" title="Добавить ссылку" 
                                :disabled="newContact.contact_url === undefined || newContact.contact_url === ''">
                            <i class="bi bi-arrow-right"></i>
                            Добавить
                        </button>
                    </div>
                </div> 
            </form>
        </div>
        
    </div>
    
</template>
<script>
export default {
    //хуки
    created(){
        // получаем список контактов
        this.$store.dispatch('getContacts');


        //получаем библиотеку соц.сетей (для добавленя новой ссылки)
        axios.get('/admin/getSocialMediaLibrary').then(response => {
            this.socialMediaLibrary = response.data;
        }).catch(error => {
            this.socialMediaLibrary = false;
        });
    },

    mounted(){
        //текущая вкладка в Links.vue
        this.$parent.currentTab = "editContacts";
    },

    //данные
    data: () => {
        return{
            addNewContact: false,
            newContact: {type: Object, default: function(){
                return {
                    contact_type: undefined,
                    contact_tooltip: undefined,
                    contact_url: undefined,
                }
            }},
            socialMediaLibrary: undefined,
            pickedSocialMedia: undefined,
            iconClass: undefined,
            urlInput: undefined,
            edit: false,
            backup: null,
            errors: null,
        }
    },

    computed: {

        contacts(){
            return this.$store.state.GlobalStates.contacts;
        },

        // надпись над полем ввода юзернейма\телефона\email'а
        tooltipTitle(){
            if(this.pickedSocialMedia !== undefined && this.pickedSocialMedia !== false)
            {
                if(this.pickedSocialMedia.insert_type === 'phone_number')
                { return `Номер телефона ${this.pickedSocialMedia.tooltip}`; }
                if(this.pickedSocialMedia.insert_type === 'username')
                { return `Имя или ID профиля ${this.pickedSocialMedia.tooltip}`; }
                if(this.pickedSocialMedia.insert_type === 'email')
                { return `Адрес электронной почты`; }
            }
            else
            { return "&nbsp"; }
        },

        //сгенерированная ссылка на соц.сеть или email
        socialMediaGeneratedLink(){
            if(this.pickedSocialMedia !== undefined && this.pickedSocialMedia !== false 
                && this.newContact.contact_url !== '' && this.pickedSocialMedia.type !== 'email')
            { return this.pickedSocialMedia.url_template.replace('{insert}', this.newContact.contact_url); }
        }
    },

    //методы
    methods: {
        //переключиться между ссылками и добавлением
        toggleAddNewContact: function(value){
            if(value === "back")
            { this.newContact = { contact_type: undefined,
                    contact_tooltip: undefined,
                    contact_url: undefined}; }

            if(this.addNewContact === false)
            this.addNewContact = true;

            else
            this.addNewContact = false; 
        },

        //выбрать соц.сеть
        pickSocialMedia(indexOfSocialMedia){
            this.pickedSocialMedia = this.socialMediaLibrary[indexOfSocialMedia];
            this.newContact.contact_type = this.pickedSocialMedia.type;
            this.newContact.contact_tooltip = this.pickedSocialMedia.tooltip;
            if(this.pickedSocialMedia.type == 'email')
            { this.iconClass = `<h6>&nbsp;</h6><i class="fas fa-at font2rem"></i>`; }
            else
            { this.iconClass = `<h6>&nbsp;</h6><i class='fab fa-${this.pickedSocialMedia.type} font2rem'></i>`; }

        },

        //сохранить новый контакт

        submit(link){
            let formData = new FormData();
            formData.append('contact_type', this.newContact.contact_type);
            formData.append('contact_tooltip', this.newContact.contact_tooltip);
            formData.append('contact_url', this.socialMediaGeneratedLink);

            axios.post('/admin/addContact', formData).then(response => {
                this.$store.dispatch('getContacts');
                this.toggleAddNewContact();
                this.newContact = {
                    contact_type: undefined,
                    contact_tooltip: undefined,
                    contact_url: undefined
                };
            }).catch(error => {
                if(error.response.status === 422){ 
                    this.errors = error.response.data.errors || {};
                }
            })
        }
    }
}
</script>