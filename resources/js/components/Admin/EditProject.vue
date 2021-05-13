//EditProject
//редактировать проект
<template>
    <div class="row mt-5 justify-content-center fadeInAnim">

        <div class="col-12" v-if="currentProject !== -1 && currentProject !== false">
            <h3 class="text-center mb-4">Редактирование "{{currentProject.project_title}}"</h3>
            <div class="row justify-content-center">
                <div class="col-4">
                    <div class="col-12 mb-4">
                        <ul class="nav nav-fill">
                            <!-- вкладки -->
                            <li class="nav-item mr-2">
                                <button class="btn btn-block btn-sm" v-on:click="showBasicForm" 
                                        v-bind:class="{'btn-light': basicFormActive === true, 'btn-outline-light': basicFormActive === false}">
                                    Общее
                                </button>
                            </li>
                            <li class="nav-item mr-2">
                                <button class="btn btn-block btn-sm" v-on:click="showImageForm"
                                        v-bind:class="{'btn-light': imageFormActive === true, 'btn-outline-light': imageFormActive === false}">
                                    Изображения
                                </button>
                            </li>
                        </ul>
                    </div>
                    <!-- основная форма -->
                    <form @submit.prevent="submit" method="POST" v-if="basicFormActive === true">
                        <input type="text" v-model="currentProject.id" class="invisible">
                        <div class="mb-3">
                            <h6>Название проекта</h6>
                            <input type="text" v-model="currentProject.project_title" class="form-control">
                            <div v-if="errors && errors.project_title" class="text-danger">{{ errors.project_title[0] }}</div>
                        </div>
                        <div class="mb-3">
                            <h6>Подзаголовок</h6>
                            <input type="text" v-model="currentProject.project_subtitle" class="form-control">
                            <div v-if="errors && errors.project_subtitle" class="text-danger">{{ errors.project_subtitle[0] }}</div>
                        </div>
                        <div class="mb-3">
                            <h6>Краткое описание</h6>
                            <textarea v-model="currentProject.project_desc" class="form-control"></textarea>
                            <div v-if="errors && errors.project_desc" class="text-danger">{{ errors.project_desc[0] }}</div>
                        </div>
                        <div class="mb-3">
                            <h6>Нижний текст</h6>
                            <input type="text" v-model="currentProject.project_bottomText" class="form-control">
                            <div v-if="errors && errors.project_bottomText" class="text-danger">{{ errors.project_bottomText[0] }}</div>
                        </div>
                        <div class="mb-3">
                            <h6>Ссылка на проект</h6>
                            <input type="text" v-model="currentProject.project_url" class="form-control">
                            <div v-if="errors && errors.project_url" class="text-danger">{{ errors.project_url[0] }}</div>
                        </div>

                        <button class="btn btn-lg btn-block btn-outline-light" v-on:click="submitBasic">
                            Сохранить
                        </button>
                    </form> 
                    <!-- форма для картинок -->
                    <form method="POST" v-if="imageFormActive === true">
                        <div class="mb-3">
                            <h6>Логотип проекта</h6>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1">
                            <!-- <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div> -->
                        </div>
                        <br><br>
                        <div class="mb-3">
                            <h6>Изображение\скриншот проекта</h6>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1">
                            <!-- <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div> -->
                        </div>

                        <button class="btn btn-lg btn-block btn-outline-light">
                            Загрузить и сохранить
                        </button>
                    </form>
                    <!-- сообщение о сохранении настроек -->
                    <div class="col-12 p-3 text-center unclickable zeroOpacity" v-bind:class="{ blinkAnim: saved }">
                        <h5>Изменения сохранены</h5>
                    </div>
                </div>
                <!-- превью -->
                <div class="col-7">
                    <PreviewProject type="full" :currentProject="currentProject"/>
                </div>
                
            </div>
            
        </div>
        
    </div>
</template>
<script>
export default {

    //хуки
    beforeMount(){
        //получаем id проекта из url
        const id = this.$route.params.id;
        //получаем проект
        this.$store.dispatch('getProject', {value: id, type: 'full'});
    },

    //данные
    data: () => {
        return {
            basicFormActive: true,
            imageFormActive: false,
            errors: {},
            saved: false,
        }
    },

    computed: {
        currentProject: function(){
            return this.$store.state.AdminStates.currentProject;
        }
    },

    //методы
    methods: {
        //показать форму для картинок
        showImageForm: function(){
            this.imageFormActive = true;
            this.basicFormActive = false;
        },

        //показать общую форму
        showBasicForm: function(){
            this.basicFormActive = true;
            this.imageFormActive = false;
        },

        //отправить основную форму
        submitBasic(){
            this.saved = false;
            this.errors = {};

            axios.post('/admin/saveProjectBasic', this.currentProject).then(response => {
                this.saved = true;
            }).catch(error => {
                if(error.response.status === 422){
                    this.errors = error.response.data.errors || {};
                }
            });
        }
    },
}
</script>