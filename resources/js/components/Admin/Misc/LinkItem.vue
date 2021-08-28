//LinkItem
//ссылка в форме

<template>
    <form method="POST" @submit.prevent="submit()">
        <div class="row justify-content-center linkItem" :id="link.slug">
            <div class="col-12 col-md-2 text-center">
                <h6>&nbsp;</h6>
                <h4>{{link.link_title}}</h4>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <h6>Сайт</h6>
                <input type="text" class="form-control" placeholder="Twitter" 
                        v-model="link.link_title" 
                        v-on:keydown="toggleEdit(true)" required>
                <div v-if="errors && errors.link_title" class="text-danger goUpAnim">{{ errors.link_title[0] }}</div>
            </div>
            <div class="col-12 col-md-4 mb-md-3">
                <h6>URL <a :href="link.link_url" target="_blank" title="Проверить ссылку"><i class="bi bi-link"></i></a></h6>

                <input type="text" class="form-control" placeholder="https://twitter.com/username" 
                       v-model="link.link_url" v-on:keydown="toggleEdit(true)" required>
                <div v-if="errors && errors.link_url" class="text-danger goUpAnim">{{ errors.link_url[0] }}</div>
            </div>
            <div class="col-12 col-md-3 mb-5 mb-md-3">
                <h6>&nbsp;</h6>
                <!-- кнопка переместить ссылку -->
                <div class="btn btn-light fadeInAnim handle" title="Переместить" v-if="edit === false">
                    <i class="bi bi-arrows-move"></i>
                </div>
                <!-- кнопка удалить ссылку -->
                <div class="btn btn-light ml-2 fadeInAnim" title="Удалить ссылку" v-if="edit === false" v-on:click="deleteLink">
                    <i class="bi bi-trash-fill"></i>
                </div>
                <!-- кнопка удалить ссылку -->
                <div class="btn btn-light ml-2 mb-1 goUpAnim" title="Отменить изменения" v-if="edit !== false" v-on:click="toggleEdit(false)">
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
    //данные
    data: () => {
        return {
            errors: null,
            edit: false,
            backup: undefined,
        }
    },

    props: {
        link: { type: Object, default: function(){
            return {
                link_title: undefined,
                link_url: undefined,
                slug: undefined,
            }
        }}
    },

    //методы
    methods: {
        
        //скрыть\показать ссылки (при ред. и сохранении)
        toggleItems(value){
            if(value == 'hide'){
                let linkItems = document.getElementsByClassName('linkItem');
                for(let item of linkItems){   
                    if(item.id !== this.link.slug){ 
                        item.classList.add("halfOpacity");
                        item.classList.add("unclickable"); 
                    } 
                }
            }

            else if (value == 'show'){
                 let linkItems = document.getElementsByClassName('linkItem');
                for(let item of linkItems){   
                    if(item.id !== this.link.slug){ 
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
                    this.backup = {'link_title': this.link.link_title, 'link_url': this.link.link_url };
                    this.toggleItems('hide');
                }
                this.edit = true;
            }

            if(value === false){ 
                this.toggleItems('show');
                this.edit = value;
                this.errors = null;
                this.link.link_title = this.backup.link_title;
                this.link.link_url = this.backup.link_url; 
            }

        },

        //сохранить измененения в ссылке
        submit(){
            
            let formData = new FormData();

            formData.append('slug', this.link.slug);
            formData.append('link_title', this.link.link_title);
            formData.append('link_url', this.link.link_url);

            axios.post('/admin/editLink', formData).then(response => {
                this.edit = false;
                this.toggleItems('show');
            }).catch(error => {
                if(error.response.status === 422){ 
                    this.errors = error.response.data.errors || {};
                }
            });
        },

        //удалить ссылку
        deleteLink(){
            this.$store.dispatch('setDeleteModalInfo', {type: 'link', link_title: this.link.link_title, slug: this.link.slug});
        }
    }
}
</script>