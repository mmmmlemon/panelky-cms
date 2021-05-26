//EditProject
//редактировать проект
<template>
    <div class="row mt-5 justify-content-center fadeInAnim">
        <div class="col-12" v-if="currentProject !== -1 && currentProject !== false">
            <div class="row justify-content-center">
                <div class="col-4">
                    <h5>Информация о проекте</h5>
                    <hr>
                    <!-- вкладки -->
                    <div class="col-12 mb-4">
                        <ul class="nav nav-fill">
                            <!-- общее -->
                            <li class="nav-item mr-2">
                                <button class="btn btn-block btn-sm" v-on:click="showBasicForm" 
                                        v-bind:class="{'btn-light': basicFormActive === true, 'btn-outline-light': basicFormActive === false}">
                                    Общее
                                </button>
                            </li>
                            <!-- изображения -->
                            <li class="nav-item mr-2">
                                <button class="btn btn-block btn-sm" v-on:click="showImageForm"
                                        v-bind:class="{'btn-light': imageFormActive === true, 'btn-outline-light': imageFormActive === false}">
                                    Изображения
                                </button>
                            </li>
                        </ul>
                    </div>
                    <!-- основная форма -->
                    <form @submit.prevent="submitBasic" method="POST" v-if="basicFormActive === true">
                        <input type="text" v-model="currentProject.id" class="invisible">
                        <!-- Название проекта -->
                        <div class="mb-3">
                            <h6>Название проекта</h6>
                            <input type="text" v-model="currentProject.project_title" class="form-control">
                            <div v-if="errors && errors.project_title" class="text-danger goUpAnim">{{ errors.project_title[0] }}</div>
                        </div>
                        <!-- Подзаголовок -->
                        <div class="mb-3">
                            <h6>Подзаголовок</h6>
                            <input type="text" v-model="currentProject.project_subtitle" class="form-control">
                            <div v-if="errors && errors.project_subtitle" class="text-danger goUpAnim">{{ errors.project_subtitle[0] }}</div>
                        </div>
                        <!-- Краткое описание -->
                        <div class="mb-3">
                            <h6>Краткое описание</h6>
                            <textarea v-model="currentProject.project_desc" class="form-control"></textarea>
                            <div v-if="errors && errors.project_desc" class="text-danger goUpAnim">{{ errors.project_desc[0] }}</div>
                        </div>
                        <!-- Нижний текст -->
                        <div class="mb-3">
                            <h6>Нижний текст</h6>
                            <input type="text" v-model="currentProject.project_bottomText" class="form-control">
                            <div v-if="errors && errors.project_bottomText" class="text-danger goUpAnim">{{ errors.project_bottomText[0] }}</div>
                        </div>
                        <!-- Ссылка на проект -->
                        <div class="mb-3">
                            <h6>Ссылка на проект</h6>
                            <input type="text" v-model="currentProject.project_url" class="form-control">
                            <div v-if="errors && errors.project_url" class="text-danger goUpAnim">{{ errors.project_url[0] }}</div>
                        </div>

                        <button class="btn btn-lg btn-block btn-outline-light" v-on:click="submitBasic">
                            Сохранить
                        </button>
                    </form> 
                    <!-- форма для картинок -->
                    <form @submit.prevent="submitImages" method="POST" action="/admin/saveProjectImages" v-if="imageFormActive === true">
                        <!-- Лого\иконка -->
                        <div class="mb-3">
                            <h6>Логотип проекта</h6>
                            <input type="file" ref="icon" class="form-control-file" v-on:change="handleFile('icon')"
                                    accept="image/jpeg, image/png">
                            <div v-if="errors && errors.projectIcon" class="text-danger">{{ errors.projectIcon[0] }}</div>
                            <a v-if="currentProject.project_icon !== null" v-on:click="deleteImage('icon')" class="btn btn-sm btn-light mt-3">Удалить иконку</a>
                        </div>
                        <br><br>
                        <!-- Изображение\скриншот -->
                        <div class="mb-3">
                            <h6>Изображение\скриншот проекта</h6>
                            <input type="file" ref="image" class="form-control-file"  v-on:change="handleFile('image')"
                                    accept="image/jpeg, image/png">
                            <div v-if="errors && errors.projectImage" class="text-danger">{{ errors.projectImage[0] }}</div>
                            <a v-if="currentProject.project_image !== null" class="btn btn-sm btn-light mt-3" v-on:click="deleteImage('image')">
                                Удалить изображение\скриншот
                            </a>
                        </div>

                        <button class="btn btn-lg btn-block btn-outline-light" :disabled="projectIcon === undefined && projectImage === undefined">
                            Загрузить и сохранить
                        </button>
                    </form>
                    <!-- сообщение о сохранении настроек -->
                    <div class="col-12 p-3 text-center unclickable zeroOpacity" v-bind:class="{ blinkAnim: saved }">
                        <h5>Изменения сохранены</h5>
                    </div>
                </div>
                <!-- превью -->
                <div class="col-6">
                    <h5>Превью</h5>
                    <hr>
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
        const slug = this.$route.params.slug;
        //получаем проект
        this.$store.dispatch('getProject', {value: slug, type: 'full'});
    },

    //данные
    data: () => {
        return {
            basicFormActive: true,
            imageFormActive: false,
            projectIcon: undefined,
            projectImage: undefined,
            errors: {},
            saved: false,
        }
    },

    computed: {
        //текущий проект
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
        },

        //записать файл в projectIcon или в projectImage
        handleFile(type){
            if(type === 'icon')
            this.projectIcon = this.$refs.icon.files[0];
            if(type === 'image')
            this.projectImage = this.$refs.image.files[0];
        },

        //отправить форму с картинками
        submitImages(){
            this.saved = false;

            let formData = new FormData();
            if(this.projectIcon !== undefined)
            {formData.append('projectIcon', this.projectIcon);}
            if(this.projectImage !== undefined)
            {formData.append('projectImage', this.projectImage);}
            if(this.currentProject !== undefined)
            {formData.append('id', this.currentProject.id);}

            axios.post('/admin/saveProjectImages', formData, {
                headers: {'Content-Type':'multipart/form-data'}
            }).then(response => {
                    this.saved = true;
                    this.projectIcon = undefined;
                    this.projectImage = undefined;
                    this.$refs.icon.value = null;
                    this.$refs.image.value = null;

                    this.currentProject.project_icon = response.data['icon'];
                    this.currentProject.project_image = response.data['image'];
                }).catch(error => {
                    if(error.response.status === 422){ 
                        this.errors = error.response.data.errors || {};
                        console.log(this.errors)
                    }
                });
        },

        //удалить картинку из проекта
        deleteImage(type){
            let formData = new FormData();
            formData.append('id', this.currentProject.id);
            formData.append('type', type);

            axios.post('/admin/deleteImageFromProject', formData).then(response => {
                if(type === 'icon')
                { this.currentProject.project_icon = null; }
                if(type === 'image')
                { this.currentProject.project_image = null; }
            }).catch(error => {
                if(error.response.status === 422){ 
                  if(error.response.status === 422 || error.response.status === 500){ 
                        var errors = error.response.data;
                        this.$store.dispatch('setErrors', error.response.data.message);
                     }
                }
            })
        }
    },
}
</script>