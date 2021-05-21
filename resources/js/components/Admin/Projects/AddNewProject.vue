//AddNewProject
//меню добавления нового проекта
<template>
    <div class="row justify-content-center fadeInAnim">
        <div class="col-12">
            <h3 class="text-center mb-4">Добавить новый проект</h3>
            <div class="row justify-content-center">
                <div class="col-4">
                    <!-- основная форма -->
                    <form @submit.prevent="submit" method="POST">
                        <input type="text" class="invisible">
                        <div class="mb-3">
                            <h6>Название проекта</h6>
                            <input type="text" v-model="currentProject.project_title" placeholder="НазваниеПроекта.ru" class="form-control" required>
                            <!-- <div v-if="errors && errors.project_title" class="text-danger">{{ errors.project_title[0] }}</div> -->
                        </div>
                        <div class="mb-3">
                            <h6>Подзаголовок</h6>
                            <input type="text" v-model="currentProject.project_subtitle" placeholder="Подзаголовок" class="form-control">
                            <!-- <div v-if="errors && errors.project_subtitle" class="text-danger">{{ errors.project_subtitle[0] }}</div> -->
                        </div>
                        <div class="mb-3">
                            <h6>Краткое описание</h6>
                            <textarea v-model="currentProject.project_desc" placeholder="Краткое описание проекта" class="form-control"></textarea>
                            <!-- <div v-if="errors && errors.project_desc" class="text-danger">{{ errors.project_desc[0] }}</div> -->
                        </div>
                        <div class="mb-3">
                            <h6>Нижний текст</h6>
                            <input type="text" v-model="currentProject.project_bottomText" placeholder="Доп. информация мелким шрифтом" class="form-control">
                            <!-- <div v-if="errors && errors.project_bottomText" class="text-danger">{{ errors.project_bottomText[0] }}</div> -->
                        </div>
                        <div class="mb-3">
                            <h6>Ссылка на проект</h6>
                            <input type="text" v-model="currentProject.project_url" placeholder="my-very-cool-project.ru" class="form-control" required>
                            <!-- <div v-if="errors && errors.project_url" class="text-danger">{{ errors.project_url[0] }}</div> -->
                        </div>
                        <div class="mb-3">
                            <h6>Логотип проекта</h6>
                            <input type="file" ref="icon" class="form-control-file" v-on:change="handleFileUpload('icon')"
                                    accept="image/jpeg, image/png">
                            <!-- <div v-if="errors && errors.projectIcon" class="text-danger">{{ errors.projectIcon[0] }}</div> -->
                        </div>
                        <div class="mb-3">
                            <h6>Изображение\скриншот проекта</h6>
                            <input type="file" ref="image" class="form-control-file"  v-on:change="handleFileUpload('image')"
                                    accept="image/jpeg, image/png">
                            <!-- <div v-if="errors && errors.projectImage" class="text-danger">{{ errors.projectImage[0] }}</div> -->
                        </div>
                        

                        <button class="btn btn-lg btn-block btn-outline-light">
                            Сохранить проект
                        </button>
                    </form> 
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
   

    //данные
    data: () => {
        return {
            currentProject: new Object({
                id: undefined,
                project_title: undefined,
                project_subtitle: undefined,
                project_desc: undefined,
                project_bottomText: undefined,
                project_icon: undefined,
                project_image: undefined,
                project_url: undefined,
            }),
            saved: false,
            errors: [],
        }
    },

     //хуки
    mounted(){
        this.$parent.currentTab = 'addProject';

        var stockImages = null;

        axios.get(`/api/getStockImages`).then(response => {
              this.currentProject.project_icon = response.data.icon;
              this.currentProject.project_image = response.data.image;
         });

        console.log(stockImages)
    },

    destroyed(){
        let formData = new FormData();
        formData.append('randomFolderName', this.randomFolderName);
        axios.post('/admin/removeFolderFromTemp', formData);
    },

    computed: {
        stockImages: function(){
            return this.$store.state.AdminStates.stockImages;
        },
        randomFolderName: function(){
            return Math.random(0,999).toString(36).substring(3);
        }
    },

    //методы
    methods: {

        handleFileUpload(type){
            let formData = new FormData();
            formData.append('randomFolderName', this.randomFolderName);
            if(type === 'icon')
            {
                formData.append('filename', "icon.png");
                formData.append('file', this.$refs.icon.files[0]);
            }

            if(type === 'image')
            {
                formData.append('filename', 'image.png');
                formData.append('file', this.$refs.image.files[0]);
            }
            
            axios.post('/admin/saveImageToTemp', formData, {
                headers: {'Content-Type': 'multipart/form-data'} 
            }).then(response => {
                if(type === 'icon')
                { this.currentProject.project_icon = response.data; }
                if(type === 'image')
                { this.currentProject.project_image = response.data; }
            }).catch(error => {
                console.log("Error uploading image to temp");
            });
        },
        submit(){
            this.saved = false;

            let formData = new FormData();
            if(this.currentProject.project_title !== undefined)
            {
                formData.append('project_title', this.currentProject.project_title);
            }
            if(this.currentProject.project_subtitle !== undefined)
            {
                formData.append('project_subtitle', this.currentProject.project_subtitle);
            }
            if(this.currentProject.project_desc !== undefined)
            {
                formData.append('project_desc', this.currentProject.project_desc);
            }
            if(this.currentProject.project_bottomText !== undefined)
            {
                formData.append('project_bottomText', this.currentProject.project_bottomText);
            }
            if(this.currentProject.project_url !== undefined)
            {
                formData.append('project_url', this.currentProject.project_url);
            }
            formData.append('randomFolderName', this.randomFolderName);

            axios.post('/admin/addNewProject', formData, {
                headers: {'Content-Type': 'multipart/form-data'} }).then(response => {
                    this.saved = true;
                    let fromData = new FormData();
                    formData.append('randomFolderName', this.randomFolderName);
                    axios.post('/admin/removeFolderFromTemp', formData).then(response => {
                         window.location.href="/admin/projects/all";
                    });
                   
                }).catch(error => {
                    if(error.response.status === 422){
                        this.errors = error.response.data.error || {};
                        console.log(this.errors);
                    }
                });
        },
    }
  
}
</script>