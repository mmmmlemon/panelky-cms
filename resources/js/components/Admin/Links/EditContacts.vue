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
                    <div class="col-12 col-md-2 text-center mt-md-0 mt-3" v-html="iconClass">   
                    </div>
                    <!-- список соц. сетей на выбор -->
                    <div class="col-md-3 text-center mt-md-0 mt-3">
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
                    <div class="col-12 col-md-4 mb-3 mt-md-0 mt-3">
                        <h6 v-html="tooltipTitle"></h6>
                        <input type="text" class="form-control" v-model="newContact.contact_url" required>
                        <div v-if="errors && errors.contact_url" class="text-danger goUpAnim">{{ errors.contact_url[0]}}</div>
                        <a v-if="socialMediaGeneratedLink !== undefined && newContact.contact_url !== undefined && newContact.contact_type !== 'email'" 
                            :href="socialMediaGeneratedLink"
                            target="_blank" class="goUpAnim">
                            Проверить ссылку
                        </a>
                    </div>
                    <!-- кнопка добавить контакт -->
                    <div class="col-12 col-md-3 mb-3">
                        <h6>&nbsp;</h6>
                        <button class="btn btn-light ml-2" title="Добавить ссылку" 
                                :disabled="pickedSocialMedia === undefined" >
                            <i class="bi bi-arrow-right"></i>
                            Добавить
                        </button>
                    </div>
                </div> 
            </form>
        </div>

        <!-- ФОРМА редактирования имеющихся контактов -->
        <div class="col-12 col-md-10 mt-5 goUpAnim" v-if="contacts !== -1" v-bind:class="{ 'invisible': addNewContact === true }" >
            
            <draggable v-model="contacts" handle=".handle" v-bind="dragOptions" class="col-12">
                <div v-for="item in contacts" :key="item.id">
                    <ContactItem :contact="item"/>
                </div>
            </draggable>
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
            // переключение в режим добавления контакта
            addNewContact: false,
            // новый контакт
            newContact: {type: Object, default: function(){
                return {
                    contact_type: undefined,
                    contact_tooltip: undefined,
                    contact_url: undefined,
                }
            }},
            // библиотека соц.сетей
            socialMediaLibrary: undefined,

            // выбранная соц.сеть
            pickedSocialMedia: undefined,
            errors: null,
        }
    },

    computed: {
        
        // все контакты
        contacts:{
            get(){
                 return this.$store.state.GlobalStates.contacts;
            }, 
            set(value){
                let formData = new FormData();
                formData.append('newOrder', JSON.stringify(value));
                this.$store.commit('setState', {state: 'contacts', value: value});
                axios.post('/admin/setNewOrderForContacts', formData).then(response => {
                    // this.$store.commit('setState', {state: 'links', value: response.data});
                }).catch(error => {
                    this.$store.dispatch('setErrors', error.response.data.message);
                });
            } 
        },

        dragOptions() {
            return {
                ghostClass: "dragGhost"
            }
        },

        // ДОБАВЛЕНИЕ 
        // надпись над полем ввода юзернейма\телефона\email'а
        tooltipTitle(){
            if(this.pickedSocialMedia !== undefined && this.pickedSocialMedia !== false){   
                switch (this.pickedSocialMedia.insert_type){
                    case 'phone_number':
                        return `Номер телефона ${this.pickedSocialMedia.tooltip}`; 
                        break;
                    case 'username':
                        return `Имя или ID профиля ${this.pickedSocialMedia.tooltip}`;
                        break;
                    case 'email':
                        return `Адрес электронной почты`;
                    default:
                        return '&nbsp';
                }
            }
            else { return '&nbsp';}
        },

        //сгенерированная ссылка на соц.сеть или email
        socialMediaGeneratedLink(){
            if(this.pickedSocialMedia !== undefined && this.pickedSocialMedia !== false 
                && this.newContact.contact_url !== '')
            { return this.pickedSocialMedia.url_template.replace('{insert}', this.newContact.contact_url); }
        },

        iconClass(){
            let icon = "";
            if(this.pickedSocialMedia !== undefined)
            {
                switch(this.pickedSocialMedia.type){
                    case 'email':
                       icon = `<h6>&nbsp;</h6><i class="goUpAnim fas fa-at font2rem"></i>`;
                       break;
                    default:
                       icon = `<h6>&nbsp;</h6><i class='goUpAnim fab fa-${this.pickedSocialMedia.type} font2rem'></i>`;
                }
            }

            return icon;
        }
    },

    //методы
    methods: {
        //переключиться между редактированием контактов и добавлением нового
        toggleAddNewContact: function(value){
            if(value === "back"){ 
                this.newContact = { contact_type: undefined,
                contact_tooltip: undefined,
                contact_url: undefined}; 
            }

            if(this.addNewContact === false){
                this.addNewContact = true;
                this.pickedSocialMedia = undefined;
            }
            else{
                this.addNewContact = false; 
            }
        },

        //выбрать соц.сеть
        pickSocialMedia(indexOfSocialMedia){
            this.pickedSocialMedia = this.socialMediaLibrary[indexOfSocialMedia];
            this.newContact.contact_type = this.pickedSocialMedia.type;
            this.newContact.contact_tooltip = this.pickedSocialMedia.tooltip;
            // if(this.pickedSocialMedia.type == 'email')
            // { this.iconClass = `<h6>&nbsp;</h6><i class="goUpAnim fas fa-at font2rem"></i>`; }
            // else
            // { this.iconClass = `<h6>&nbsp;</h6><i class='goUpAnim fab fa-${this.pickedSocialMedia.type} font2rem'></i>`; }

        },

        //сохранить новый контакт

        submit(link){
            let formData = new FormData();
            formData.append('contact_type', this.newContact.contact_type);
            formData.append('contact_tooltip', this.newContact.contact_tooltip);
            formData.append('contact_url', this.socialMediaGeneratedLink);
            formData.append('contact_insertion', this.newContact.contact_url);

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