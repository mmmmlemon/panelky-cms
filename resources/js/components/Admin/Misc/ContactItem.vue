// ContactItem
// контакт в форме
<template>
    <form method="POST" @submit.prevent="submit()">
        <div class="row justify-content-center contactItem" :id="contact.id">
            <!-- иконка соц.сети -->
            <div class="col-12 col-md-2 text-center" v-html="iconClass">   
            </div>

            <!-- список соц. сетей на выбор -->
            <div class="col-md-3 text-center">
                <div class="dropdown">
                <h6>&nbsp;</h6>
                    <button class="btn btn-light btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <b>{{contact.contact_tooltip}}</b>

                    </button>
                    <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                        <a v-for="(socialMedia, index) in socialMediaLibrary" 
                            v-bind:key="index" class="dropdown-item pointer"
                            @click="toggleEdit(true); pickSocialMedia(index);">
                            {{socialMedia.tooltip}}
                        </a>
                    </div>
                </div>
            </div>

            <!-- поле для email/юзернейма в соц.сети или номера телефона -->
            <div class="col-12 col-md-4 mb-3">
                <h6 v-html="tooltipTitle"></h6>
                <input type="text" class="form-control" v-model="contact.contact_insertion" required v-on:keydown="toggleEdit(true)">
                <div v-if="errors && errors.contact_url" class="text-danger goUpAnim">{{ errors.contact_url[0]}}</div>
                <a v-if="contact.contact_url !== undefined" 
                    :href="socialMediaGeneratedLink"
                    target="_blank" class="goUpAnim">
                    Проверить ссылку
                </a>
            </div>

            <!-- кнопки -->
            <div class="col-12 col-md-3 mb-5 mb-md-3">
                <h6>&nbsp;</h6>
                <!-- кнопка переместить ссылку -->
                <div class="btn btn-light fadeInAnim handle" title="Переместить" v-if="edit === false">
                    <i class="bi bi-arrows-move"></i>
                </div>
                <!-- кнопка удалить ссылку -->
                <div class="btn btn-light ml-2 fadeInAnim" title="Удалить ссылку" v-if="edit === false" @click="deleteContact">
                    <i class="bi bi-trash-fill"></i>
                </div>
                <!-- кнопка удалить ссылку -->
                <div class="btn btn-light ml-2 mb-1 goUpAnim" title="Отменить изменения" v-if="edit !== false" @click="toggleEdit(false)">
                    <i class="bi bi-x"></i>
                    Отмена
                </div>
                <!-- кнопка удалить ссылку -->
                <button class="btn btn-light ml-2 goUpAnim" title="Сохранить изменения" v-if="edit !== false">
                    <i class="bi bi-save"></i>
                    Сохранить
                </button>
            </div>
        </div> 
    </form>
</template>
<script>
export default {
    created(){
        
        // for(let i = 0; i <= this.socialMediaLibrary.length; i++)
        // {
        //     console.log(this.socialMediaLibrary[i])
        // }
    },

    //данные
    data: () => {
        return {
            errors: null,
            edit: false,
            backup: undefined,
            pickedSocialMedia: undefined,
        }
    },
    
    props: {
        contact: { type: Object, default: function(){
            return {
                contact_type: undefined,
                contact_tooltip: undefined,
                contact_url: undefined,
                contact_insertion: undefined,
            }
        }}
    },

    computed: {
        // библиотека соц. сетей
        socialMediaLibrary(){
            return this.$parent.$parent.socialMediaLibrary;
        },

        // класс для иконки
        iconClass(){
            if(this.contact.contact_type === 'email')
            { return `<h6>&nbsp;</h6><i class="goUpAnim fas fa-at font2rem"></i>`; }
            else
            { return `<h6>&nbsp;</h6><i class="goUpAnim fab fa-${this.contact.contact_type} font2rem"></i>`; }
        },

        //сгенерированная ссылка на соц.сеть или email
        socialMediaGeneratedLink(){
            if(this.pickedSocialMedia !== undefined && this.pickedSocialMedia !== false 
                && this.contact.contact_url !== '')
            { return this.pickedSocialMedia.url_template.replace('{insert}', this.contact.contact_insertion); }
            else {
                if(this.socialMediaLibrary !== undefined)
                {
                    var urlTemplate = '';
                    for(let item of this.socialMediaLibrary){
                        if(item.type === this.contact.contact_type){
                            urlTemplate = item.url_template.replace('{insert}', this.contact.contact_insertion); ;
                        }
                    }
                }
                return urlTemplate;
            }
        },

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
    },

    methods: {
        //выбрать соц.сеть
        pickSocialMedia(indexOfSocialMedia){
            this.pickedSocialMedia = this.socialMediaLibrary[indexOfSocialMedia];
            this.contact.contact_type = this.pickedSocialMedia.type;
            this.contact.contact_tooltip = this.pickedSocialMedia.tooltip;
        },

        //скрыть\показать ссылки (при ред. и сохранении)
        toggleItems(value){
            if(value == 'hide'){
                let contactItems = document.getElementsByClassName('contactItem');
                for(let item of contactItems){   
                    if(parseInt(item.id) !== this.contact.id){ 
                        item.classList.add("halfOpacity");
                        item.classList.add("unclickable"); 
                    } 
                }
            }
            else if (value == 'show'){
                let contactItems = document.getElementsByClassName('contactItem');
                for(let item of contactItems){   
                    if(parseInt(item.id) !== this.contact.id){ 
                        item.classList.remove("halfOpacity");
                        item.classList.remove("unclickable"); 
                    } 
                }
            }
        },

        //вкл\выкл режим редактирования
        toggleEdit(value){
            if(value === true){
                if(this.edit === false){ 
                    this.backup = {'contact_type': this.contact.contact_type, 
                                    'contact_tooltip': this.contact.contact_tooltip, 
                                    'contact_url': this.contact.contact_url, 
                                    'contact_insertion': this.contact.contact_insertion,
                                     };
                    this.toggleItems('hide');
                }
                this.edit = true;
            }

            if(value === false){ 
                this.toggleItems('show');
                this.edit = value;
                this.errors = null;
                this.pickedSocialMedia = undefined;
                this.contact.contact_type = this.backup.contact_type;
                this.contact.contact_tooltip = this.backup.contact_tooltip;
                this.contact.contact_url = this.backup.contact_url;
                this.contact.contact_insertion = this.backup.contact_insertion;
             }

        },

        // сохранить изменения
        submit(){
            let formData = new FormData();

            formData.append('contact_id', this.contact.id);
            formData.append('contact_type', this.contact.contact_type);
            formData.append('contact_tooltip', this.contact.contact_tooltip);
            formData.append('contact_url', this.socialMediaGeneratedLink);
            formData.append('contact_insertion', this.contact.contact_insertion);

            axios.post('/admin/editContact', formData).then(response => {
                this.edit = false;
                this.toggleItems('show');
            }).catch(error => {
                if(error.response.status === 422){ 
                    this.errors = error.response.data.errors || {};
                }
            });
        },

        //удалить контакт
        deleteContact(){
            this.$store.dispatch('setDeleteModalInfo', {type: 'contact', contact_tooltip: this.contact.contact_tooltip, id: this.contact.id});
        }
    }

}
</script>