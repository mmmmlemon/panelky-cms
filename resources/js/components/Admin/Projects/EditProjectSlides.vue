// EditProjectSlides.vue
// редактирование слайдов проекта
<template>
    <!-- форма для картинок -->
    <form @submit.prevent="submitSlide" class="fadeInAnim" method="POST">
        <!-- Лого\иконка -->
        <div class="mb-3">
            <h6>Скриншот, gif или короткое видео проекта</h6>
            <input type="file" class="form-control-file" ref="media" @change="handleMedia"
                    accept="image/jpeg, image/png, image/gif, video/mp4,video/x-m4v,video/*">
            <div v-if="errors && errors.slideMedia" class="text-danger">{{errors.slideMedia[0] }}</div>
            <a class="btn btn-sm btn-light mt-3">Удалить медиа</a>
        </div>
        <div class="mb-3">
            <h6>Комментарий</h6>
            <input type="text" v-model="slideComment" placeholder="Комментарий к слайду" class="form-control">
            <div v-if="errors && errors.slideComment" class="text-danger goUpAnim">{{ errors.slideComment[0] }}</div>
        </div>
        <button class="btn btn-lg btn-block btn-outline-light">
            Загрузить и сохранить
        </button>
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
            slideComment: undefined,
        }
    },

    props: {
        projectId: {default: null}
    },

    // методы
    methods: {
        // сохранить слайд
        submitSlide(){
            this.saved = false;

            let formData = new FormData();
            if(this.slideMedia !== undefined)
            { formData.append('slideMedia', this.slideMedia); }
            if(this.projectId !== null)
            { formData.append('projectId', this.projectId); }
            if(this.slideComment !== undefined)
            { formData.append('slideComment', this.slideComment); }

            axios.post('/admin/saveProjectSlide', formData, {
                headers: {'Content-Type':'multipart/form-data'}
            }).then(response => {
                this.saved = true;
                this.projectIcon = undefined;
                this.projectImage = undefined;
            }).catch(error => {
                if(error.response.status === 422){ 
                    this.errors = error.response.data.errors || {};
                    console.log(this.errors)
                }
            })
        },

        //записать файл в projectIcon или в projectImage
        handleMedia(){
            this.slideMedia = this.$refs.media.files[0];
        },
    }
}
</script>