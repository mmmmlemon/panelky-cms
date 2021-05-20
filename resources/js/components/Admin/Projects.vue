//Projects
//вкладка в админке, список проектов
<template>
    <div class="row mt-5 justify-content-center fadeInAnim">
        <div class="col-6 mb-5">
            <ul class="nav nav-fill">
                <li class="nav-item mr-2" v-on:click="changeCurrentTab('homeProjects')">
                    <router-link to="/admin/projects" v-bind:class="{'btn-light': currentTab === 'homeProjects', 
                                                'btn-outline-light': currentTab !== 'homeProjects'}"
                                                class="btn btn-sm btn-block" aria-current="page"
                                                >
                        <i class="bi bi-file-earmark-check"></i>
                       Проекты на главной
                    </router-link>
                </li>
                <li class="nav-item mr-2" v-on:click="changeCurrentTab('allProjects')">
                    <router-link to="/admin/projects/all" v-bind:class="{'btn-light': currentTab === 'allProjects', 
                                                'btn-outline-light': currentTab !== 'allProjects'}"
                                                 class="btn btn-sm btn-block" 
                                                 >
                        <i class="bi bi-files"></i>
                        Все проекты
                    </router-link>
                </li>
                <li class="nav-item mr-2" v-on:click="changeCurrentTab('addProject')">
                    <router-link to="/admin/projects/add" v-bind:class="{'btn-light': currentTab === 'addProject', 
                                                'btn-outline-light': currentTab !== 'addProject'}"
                                                 class="btn btn-sm btn-block" 
                                                >
                        <i class="bi bi-file-earmark-plus"></i>
                        Добавить проект
                    </router-link>
                </li>
        </ul>
        </div>
        <br>
        <div class="col-12">
            <router-view>
            </router-view>  
        </div>
    </div>
</template>

<script>
export default {
    //хуки
    beforeMount(){
        //текущая вкладка
        this.$store.dispatch('setCurrentTab', 'projects');
        //получить список проектов
        this.$store.dispatch('getProjectsList');
    },

    mounted(){
        var currentProject = this.$store.getters.currentProject;

        if(currentProject === -1)
        { 
            //установить первый проект в списке выбранным по умолчанию
            this.$store.dispatch('setFirstProjectSlug');
        }
    },

    //данные
    data: () => {
        return {
            currentTab: 'homeProjects',
        }
    },

    //методы
    methods: {
        changeCurrentTab: function(tab){
            this.currentTab = tab;
        },
    }
}
</script>