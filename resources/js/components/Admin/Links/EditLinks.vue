//EditLinks
//форма редактирования ссылок
<template>
    <div class="row justify-content-center mb-5">
        <div class="col-12 col-md-10 mt-2">
            <button class="btn btn-light fadeInAnim" title="Добавить ссылку" 
                    v-on:click="toggleAddNewLink" v-bind:class="{ 'invisible': addNewLink === true   }">
                <i class="bi bi-plus"></i>
                Добавить ссылку
            </button>
            
            <button class="btn btn-light" title="Добавить ссылку" 
                    v-on:click="toggleAddNewLink('back')" v-bind:class="{ 'invisible': addNewLink === false }">
                <i class="bi bi-arrow-left"></i>
                Назад
            </button>
        </div>
        <div class="col-12 col-md-10 mt-5 goUpAnim" v-bind:class="{ 'invisible': addNewLink === false }">
            <!-- форма добавить новую ссылку -->
            <form method="POST" @submit.prevent="submit()">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-2 text-center">
                        <h6>&nbsp;</h6>
                        <h4>{{newLink.link_title}}</h4>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <h6>Сайт</h6>
                        <input type="text" class="form-control" placeholder="Twitter" v-model="newLink.link_title" required>
                        <div v-if="errors && errors.link_title" class="text-danger goUpAnim">{{ errors.link_title[0] }}</div>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <h6>URL</h6>
                        <input type="text" class="form-control" placeholder="https://twitter.com/username" v-model="newLink.link_url" required>
                        <div v-if="errors && errors.link_url" class="text-danger goUpAnim">{{ errors.link_url[0] }}</div>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <h6>&nbsp;</h6>
                        <!-- кнопка удалить ссылку -->
                        <button class="btn btn-light ml-2" title="Добавить ссылку">
                            <i class="bi bi-arrow-right"></i>
                            Добавить
                        </button>
                    </div>
                </div> 
            </form>
        </div>
        <div class="col-12 col-md-8 mt-5 text-center goUpAnim" v-if="links === false" v-bind:class="{ 'invisible': addNewLink === true }">
            <h3>Нет ссылок</h3>
            <i class="bi bi-link font1-8rem"></i>
            <hr>
            <h5>Но их никогда не поздно добавить!</h5>
        </div>
        <div class="col-12 col-md-10 mt-5 goUpAnim" v-if="links !== -1" v-bind:class="{ 'invisible': addNewLink === true }" >
            <!-- форма редактирования имеющихся ссылок -->
            <draggable v-model="links" handle=".handle" v-bind="dragOptions" class="col-12">
                <div v-for="item in links" :key="item.id">
                    <LinkItem :link="item"/>
                </div>
            </draggable>
        </div>
    </div>
</template>
<script>
export default {
    //хуки
    mounted(){
        //текущая вкладка в Links.vue
        this.$parent.currentTab = "editLinks";
        this.$store.dispatch('getLinks');
    },

    //данные
    data: () => {
        return {
            addNewLink: false,
            newLink: {type: Object, default: function(){
                return {
                    link_title: undefined,
                    link_url: undefined,
                }
            }},
            errors: null,
        }
    },

    computed: {
        links: {
            get(){
                 return this.$store.state.GlobalStates.links;
            },

            set(value){
                let formData = new FormData();
                formData.append('newOrder', JSON.stringify(value));
                this.$store.commit('setState', {state: 'links', value: value});
                axios.post('/admin/setNewOrderForLinks', formData).then(response => {
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
    },

    //методы
    methods: {
        //переключиться между ссылками и добавлением
        toggleAddNewLink: function(value){
            if(value === "back")
            { this.newLink = {link_title: undefined,
                              link_url: undefined}; }

            if(this.addNewLink === false)
            this.addNewLink = true;

            else
            this.addNewLink = false;
        },

        //отправить новую ссылку
        submit(link){
            
            let formData = new FormData();
            formData.append('link_title', this.newLink.link_title);
            formData.append('link_url', this.newLink.link_url);

            axios.post('/admin/addLink', formData).then(response => {
                this.$store.dispatch('getLinks');
                this.toggleAddNewLink();
                this.newLink = {
                    link_title: undefined,
                    link_url: undefined,
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