//EditLinks
//форма редактирования ссылок
<template>
    <div class="row justify-content-center">
        <div class="col-8 mt-2">
            <button class="btn btn-light" title="Добавить ссылку" 
                    v-on:click="toggleAddNewLink" v-bind:class="{ 'invisible': addNewLink === true   }">
                <i class="bi bi-plus"></i>
                Добавить ссылку
            </button>
            
            <button class="btn btn-light" title="Добавить ссылку" 
                    v-on:click="toggleAddNewLink" v-bind:class="{ 'invisible': addNewLink === false }">
                <i class="bi bi-arrow-left"></i>
                Назад
            </button>
        </div>
        <div class="col-8 mt-5 goUpAnim" v-bind:class="{ 'invisible': addNewLink === false }">
            <!-- форма редактирования имеющихся ссылок -->
            <form method="POST">
                <div class="row justify-content-center">
                    <div class="col-2 text-center">
                        <h6>&nbsp;</h6>
                        <h4></h4>
                    </div>
                    <div class="col-3 mb-3">
                        <h6>Название ресурса</h6>
                        <input type="text" class="form-control" placeholder="Twitter" required>
                        <!-- <div v-if="errors && errors.name" class="text-danger goUpAnim">{{ errors.name[0] }}</div> -->
                    </div>
                    <div class="col-4 mb-3">
                        <h6>URL</h6>
                        <input type="text" class="form-control" placeholder="https://twitter.com/username"  required>
                        <!-- <div v-if="errors && errors.name" class="text-danger goUpAnim">{{ errors.name[0] }}</div> -->
                    </div>
                    <div class="col-3 mb-3">
                        <h6>&nbsp;</h6>
                        <!-- кнопка удалить ссылку -->
                        <button class="btn btn-light ml-2" title="Добавить ссылку">
                            <i class="bi bi-arrow-right"></i>
                            Добавить
                        </button>
                    </div>
                </div> 
                <hr>
            </form>
        </div>
        <div class="col-8 mt-5 goUpAnim" v-if="links !== -1" v-bind:class="{ 'invisible': addNewLink === true }">
            <!-- форма редактирования имеющихся ссылок -->
            <div v-for="item in links" :key="item.id">
                <LinkItem :link="item"/>
            </div>
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
            // links: [
            //     {
            //         id: 0,
            //         link_title: 'GitHub',
            //         link_url: 'https://github.com',
            //         link_slug: 'github',
            //     },
            //     {
            //         id: 1,
            //         link_title: 'Instagram',
            //         link_url: 'https://instagram.com',
            //         link_slug: 'instagram',
            //     }
            // ]
        }
    },

    computed: {
        links: function(){
            return this.$store.state.AdminStates.links;
        },
    },

    //методы
    methods: {
        toggleAddNewLink: function(){
            if(this.addNewLink === false)
            this.addNewLink = true;

            else
            this.addNewLink = false;
        },

        submit(link){
            console.log(link)
        }
    }
}
</script>