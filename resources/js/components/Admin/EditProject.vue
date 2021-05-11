//EditProject
//редактировать проект
<template>
    <div class="row mt-5 justify-content-center fadeInAnim" v-if="currentProject !== -1">
        <div class="col-12">
            <h3 class="text-center mb-4">Редактирование "{{currentProject.project_title}}"</h3>
            <div class="row justify-content-center">
                <div class="col-4">
                    <div class="col-12 mb-4">
                        <ul class="nav nav-fill">
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
                    <form method="POST" v-if="basicFormActive === true">
                        <div class="mb-3">
                            <h6>Название проекта</h6>
                            <input type="text" v-model="currentProject.project_title" class="form-control">
                            <!-- <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div> -->
                        </div>
                        <div class="mb-3">
                            <h6>Подзаголовок</h6>
                            <input type="text" v-model="currentProject.project_subtitle" class="form-control">
                            <!-- <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div> -->
                        </div>
                        <div class="mb-3">
                            <h6>Краткое описание</h6>
                            <textarea v-model="currentProject.project_desc" class="form-control"></textarea>
                            <!-- <div v-if="errors && errors.aboutMe" class="text-danger">{{ errors.aboutMe[0] }}</div> -->
                        </div>
                        <div class="mb-3">
                            <h6>Нижний текст</h6>
                            <input type="text" v-model="currentProject.project_bottomText" class="form-control">
                            <!-- <div v-if="errors && errors.aboutMe" class="text-danger">{{ errors.aboutMe[0] }}</div> -->
                        </div>
                        <div class="mb-3">
                            <h6>Ссылка на проект</h6>
                            <input type="text" v-model="currentProject.project_url" class="form-control">
                            <!-- <div v-if="errors && errors.aboutMe" class="text-danger">{{ errors.aboutMe[0] }}</div> -->
                        </div>

                        <button class="btn btn-lg btn-block btn-outline-light">
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
                </div>
                <div class="col-7">
                    <PreviewProject type="full" :currentProject="currentProject"/>
                </div>
                
            </div>
            
        </div>
        
    </div>
</template>
<script>
export default {
    data: () => {
        return {
            basicFormActive: true,
            imageFormActive: false,
        }
    },

    methods: {
        showImageForm: function(){
            this.imageFormActive = true;
            this.basicFormActive = false;
        },

        showBasicForm: function(){
            this.basicFormActive = true;
            this.imageFormActive = false;
        }
    },

    computed: {
        currentProject: function(){
            return this.$store.state.AdminStates.currentProject;
        }
    },

    beforeMount(){
        //получаем id проекта из url
        const id = this.$route.params.id;
        console.log(`Project ID is '${id}'`)
        this.$store.dispatch('getProject', {value: id, type: 'full'});
    }

}
</script>