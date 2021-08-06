// EditProjectSlides.vue
// редактирование слайдов проекта
<template>
    <!-- форма для картинок -->
    <form @submit.prevent="submitSlide" class="fadeInAnim " method="POST">
        <!-- изображение -->
        <div class="mb-3 slideForm" v-bind:class="{'unavaliable': projectSlides.length >= 5 }">
            <h6>Скриншот, gif или короткое видео проекта</h6>
            <input type="file" class="form-control-file" ref="media" @change="handleMedia"
                    accept="image/jpeg, image/png, image/gif, video/mp4,video/x-m4v,video/*">
            <div v-if="errors && errors.slideMedia" class="text-danger">{{errors.slideMedia[0] }}</div>
            <a class="btn btn-sm btn-light mt-3" v-if="slideMedia !== undefined">Удалить медиа</a>
        </div>

        <!-- видимость -->
        <div class="mt-5">
            <h6>Видимость в положении экрана</h6>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio3" value="all" v-model="slideVisibility">
                <label class="form-check-label" for="inlineRadio3">Горизонатально и вертикально</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" value="desktop" v-model="slideVisibility">
                <label class="form-check-label" for="inlineRadio1">Горизонтально</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" value="mobile" v-model="slideVisibility">
                <label class="form-check-label" for="inlineRadio2">Вертикально</label>
            </div>
 
        </div>
        
    

        <!-- комментарий -->
        <div class="mt-5 mb-3 slideForm" v-bind:class="{'unavaliable': projectSlides.length >= 5 }">
            <h6>Комментарий</h6>
            <input type="text" v-model="slideComment" placeholder="Комментарий к слайду, отображается под слайдом" class="form-control">
            <div v-if="errors && errors.slideComment" class="text-danger goUpAnim">{{ errors.slideComment[0] }}</div>
        </div>
        <button class="btn btn-lg btn-block btn-outline-light slideForm" v-bind:class="{'unavaliable': projectSlides.length >= 5 }">
            Загрузить и сохранить
        </button>

        <!-- превью слайдов -->
        <div class="row justify-content-center mt-5">
            <div class="col-12">
                <h5 class="text-center">Горизонтальные слайды</h5>
                <hr>
                <div class="row justify-content-center">
                    <div v-for="(slide, index) in projectSlides.horizontal" v-bind:key="index" class="col-2 text-center fadeInAnim">
                        <img :src="slide.media_url" class="slideEditImage">
                        <h3 class="slideEditImageNum">{{index+1}}</h3>
                        <h6 @click="deleteSlide(slide.id)" class="deleteSlide m-2"><b>Ред. комментарий</b></h6>
                        <h6 @click="deleteSlide(slide.id)" class="deleteSlide m-2"><b>Удалить</b></h6>
                    </div>
                </div>
                <h5 class="text-center">Вертикальные слайды</h5>
                <hr>
                <div class="row justify-content-center mt-5">
                    <div v-for="(slide, index) in projectSlides.vertical" v-bind:key="index" class="col-2 text-center fadeInAnim">
                        <img :src="slide.media_url" class="slideEditImage">
                        <h3 class="slideEditImageNum">{{index+1}}</h3>
                        <h6 @click="deleteSlide(slide.id)" class="deleteSlide m-2"><b>Ред. комментарий</b></h6>
                        <h6 @click="deleteSlide(slide.id)" class="deleteSlide m-2"><b>Удалить</b></h6>
                    </div>
                </div>
               
            </div>
        </div>

    </form>
</template>
<script>
export default {

    // данные
    data: () => {
        return {
            errors: {},
            saved: false,
            slideMedia: undefined,
            slideVisibility: 'all',
            slideComment: undefined,
        }
    },

    props: {
        projectId: {default: null},
        projectSlug: {default: null}
    },

    computed: {
        projectSlides: function(){
            return this.$store.state.AdminStates.currentProject.slides;
        }
    },

    // методы
    methods: {
        // сохранить слайд
        submitSlide(){
            this.saved = false;

            let formData = new FormData();
            if(this.projectId !== null)
            { formData.append('projectId', this.projectId); }
            if(this.slideMedia !== undefined)
            { formData.append('slideMedia', this.slideMedia); }
            if(this.slideVisibility !== undefined)
            { formData.append('slideVisibility', this.slideVisibility); }
            if(this.slideComment !== undefined)
            { formData.append('slideComment', this.slideComment); }

            axios.post('/admin/saveProjectSlide', formData, {
                headers: {'Content-Type':'multipart/form-data'}
            }).then(response => {
                this.saved = true;
                this.projectIcon = undefined;
                this.projectImage = undefined;
                this.slideMedia = undefined;
                this.slideComment = undefined;
                this.$refs.media.value = null;
                this.$store.dispatch('getProject', {value: this.projectSlug, type: 'full'});
            }).catch(error => {
                if(error.response.status === 422){ 
                    this.errors = error.response.data.errors || {};
                    console.log(this.errors);
                }
            })
        },

        //удалить слайд
        deleteSlide(slideId){

            let formData = new FormData();
            formData.append('slideId', slideId);

            axios.post('/admin/deleteProjectSlide', formData).then(response => {
                if(response.data === true){
                    this.$store.dispatch('getProject', {value: this.projectSlug, type: 'full'});
                }
            }).catch(error => {
                console.log(error.errors);
            })

        },

        //записать файл в projectIcon или в projectImage
        handleMedia(){
            this.slideMedia = this.$refs.media.files[0];
        },
    }
}
</script>