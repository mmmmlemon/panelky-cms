// EditProjectSlides.vue
// редактирование слайдов проекта
<template>
    <!-- форма для картинок -->
    <form @submit.prevent="submitSlide" class="fadeInAnim " method="POST">
        <!-- изображение -->
        <div class="mb-3 slideForm" v>
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
                <input class="form-check-input" type="radio" id="inlineRadio1" value="horizontal" v-model="slideVisibility">
                <label class="form-check-label" for="inlineRadio1">Горизонтально</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" value="vertical" v-model="slideVisibility">
                <label class="form-check-label" for="inlineRadio2">Вертикально</label>
            </div>
 
        </div>
        
    

        <!-- комментарий -->
        <div class="mt-5 mb-3 slideForm">
            <h6>Комментарий</h6>
            <textarea type="text" v-model="slideComment" placeholder="Комментарий к слайду, отображается под слайдом" class="form-control"></textarea>
            <div v-if="errors && errors.slideComment" class="text-danger goUpAnim">{{ errors.slideComment[0] }}</div>
        </div>
        <button class="btn btn-lg btn-block btn-outline-light slideForm">
            Загрузить и сохранить
        </button>

        <!-- превью слайдов -->
        <div class="row justify-content-center mt-5">
            <div class="col-12">
                <h5 class="text-center mt-5" v-if="projectSlidesHorizontal != 0">Горизонтальные слайды</h5>
                <hr v-if="projectSlidesHorizontal != 0">
                <draggable v-model="projectSlidesHorizontal" handle=".handle" v-bind="dragOptions" class="row justify-content-center">
                    <div v-for="(slide, index) in projectSlidesHorizontal" 
                         v-bind:key="'horizontalSlide_'+index" 
                         class="col-8 col-md-2 text-center m-2 fadeInAnim">
                        <img :src="slide.media_url" class="slideEditImage">
                        <h3 class="slideEditImageNum">{{index+1}}</h3>
                        <!-- кнопки под слайдами -->
                        <div class="row justify-content-center mt-2">
                            <div v-if="slideEditId !== slide.id" class="col-4 text-center">
                                <h5 @click="editSlide(index, 'horizontal')" class="deleteSlide m-2 goUpAnim pointer" title="Редактировать комментарий к слайду">
                                    <i class="bi bi-pencil"></i>
                                </h5>
                            </div>
                            <div v-if="slideEditId === slide.id" class="col-4 text-center goUpAnim pointer" title="Сохранить изменения">
                                <h5 @click="saveSlideChanges" class="deleteSlide m-2">
                                    <i class="bi bi-save"></i>
                                </h5>
                            </div>
                            <div class="col-4 text-center">
                                <h5 @click="deleteSlide(slide.id)" class="deleteSlide m-2 pointer" title="Удалить слайд">
                                    <i class="bi bi-trash"></i>
                                </h5>
                            </div>
                            <div class="col-4 text-center pointer" title="Переместить слайд">
                                <h5 class="handle m-2">
                                    <i class="bi bi-arrows-move deleteSlide"></i>
                                </h5>
                            </div>
                        </div> 
                        <!-- редактировать слайд - горизонтальные -->
                        <div class="d-block d-md-none row justify-content-center mt-3 goUpAnim" v-if="slideEditId !== undefined && slideEditMode === 'horizontal' &&
                        slideEditId === slide.id">
                            <div class="col-12 text-center">
                                <textarea type="text" v-model="slideEditComment" placeholder="Комментарий к слайду, отображается под слайдом" class="form-control">
                                </textarea>
                            </div>                    
                        </div>
  
                    </div>
                </draggable>
                
                <!-- редактировать слайд - горизонтальные -->
                <div class="d-none d-md-flex row justify-content-center mt-5 goUpAnim" v-if="slideEditId !== undefined && slideEditMode === 'horizontal'">
                    <div class="col-6 text-center">
                        <textarea type="text" v-model="slideEditComment" placeholder="Комментарий к слайду, отображается под слайдом" class="form-control">
                        </textarea>
                    </div>                    
                </div>

                <h5 class="text-center mt-5" v-if="projectSlidesVertical != 0">Вертикальные слайды</h5>
                <hr v-if="projectSlidesVertical != 0">
                <draggable v-model="projectSlidesVertical" handle=".handle" v-bind="dragOptions" class="row justify-content-center mt-5">
                    <div v-for="(slide, index) in projectSlidesVertical" v-bind:key="'verticalSlide_'+index" class="col-6 col-md-2 m-2 text-center fadeInAnim">
                        <img :src="slide.media_url" class="slideEditImage">
                        <h3 class="slideEditImageNum">{{index+1}}</h3>
                        <!-- кнопки под слайдами -->
                        <div class="row justify-content-center mt-2">
                            <div v-if="slideEditId !== slide.id" class="col-4 text-center pointer">
                                <h5 @click="editSlide(index, 'vertical')" class="deleteSlide m-2 goUpAnim" title="Редактировать комментарий к слайду">
                                    <i class="bi bi-pencil"></i>
                                </h5>
                            </div>
                            <div v-if="slideEditId === slide.id" class="col-4 text-center goUpAnim pointer" title="Сохранить изменения">
                                <h5 @click="saveSlideChanges" class="deleteSlide m-2">
                                    <i class="bi bi-save"></i>
                                </h5>
                            </div>
                            <div class="col-4 text-center">
                                <h5 @click="deleteSlide(slide.id)" class="deleteSlide m-2 pointer" title="Удалить слайд">
                                    <i class="bi bi-trash"></i>
                                </h5>
                            </div>
                            <div class="col-4 text-center">
                                <h5 @click="deleteSlide(slide.id)" class="handle m-2 deleteSlide pointer" title="Переместить слайд">
                                    <i class="bi bi-arrows-move"></i>
                                </h5>
                            </div>
                        </div>
                    <!-- редактировать слайд - вертикальные -->
                    <div class="d-block d-md-none row justify-content-center mt-3 goUpAnim" v-if="slideEditId !== undefined && slideEditMode === 'vertical' &&
                    slideEditId === slide.id">
                        <div class="col-12 text-center">
                            <textarea type="text" v-model="slideEditComment" placeholder="Комментарий к слайду, отображается под слайдом" class="form-control">
                            </textarea>
                        </div>                    
                    </div>
                    </div>
              
                </draggable>

                <!-- редактировать слайд - вертикальные -->
                <div class="d-none d-md-flex row justify-content-center mt-5 goUpAnim" v-if="slideEditId !== undefined && slideEditMode === 'vertical'">
                    <div class="col-md-6 text-center">
                        <textarea type="text" v-model="slideEditComment" placeholder="Комментарий к слайду, отображается под слайдом" class="form-control">
                        </textarea>
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
            slideEditId: undefined,
            slideEditComment: undefined,
            slideEditMode: undefined,
        }
    },

    props: {
        projectId: {default: null},
        projectSlug: {default: null}
    },

    computed: {
        // горизонтальные слайды
        projectSlidesHorizontal:{
            get(){
                return this.$store.state.AdminStates.currentProject.slides.horizontal;
            },
            set(value){
                let formData = new FormData();
                formData.append('newOrder', JSON.stringify(value));
                formData.append('type', 'horizontal');

                //обновляем стейт currentProject чтобы не было мерцания при перемещении слайда
                let currentProject = this.$parent.currentProject;
                currentProject.slides.horizontal = value;
                this.$store.commit('setState', {state: 'currentProject', value: currentProject});

                axios.post('/admin/setNewOrderForSlides', formData).then(response => {
                    this.$store.dispatch('getProject', {value: this.projectSlug, type: 'full'});
                    this.slidePreviewClass = '';
                }).catch(error => {
                    this.$store.dispatch('setErrors', error.response.data.message);
                });
            }   
        },

        projectSlidesVertical:{

            get(){
                return this.$store.state.AdminStates.currentProject.slides.vertical;
            },
            set(value){
                let formData = new FormData();
                formData.append('newOrder', JSON.stringify(value));
                formData.append('type', 'vertical');

                //обновляем стейт currentProject чтобы не было мерцания при перемещении слайда
                let currentProject = this.$parent.currentProject;
                currentProject.slides.vertical = value;
                this.$store.commit('setState', {state: 'currentProject', value: currentProject});

                axios.post('/admin/setNewOrderForSlides', formData).then(response => {
                    this.$store.dispatch('getProject', {value: this.projectSlug, type: 'full'});
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
            });
        },

        //редактировать слайд
        editSlide(slideIndex, editMode){
            this.slideEditMode = editMode;
            if(editMode === 'horizontal')
            {
                this.slideEditId = this.projectSlidesHorizontal[slideIndex].id;
                this.slideEditComment = this.projectSlidesHorizontal[slideIndex].commentary;
            }
            else if (editMode === 'vertical')
            {
                this.slideEditId = this.projectSlidesVertical[slideIndex].id;
                this.slideEditComment = this.projectSlidesVertical[slideIndex].commentary;
            }
        },

        //сохранить изменения в слайде
        saveSlideChanges(){
            let formData = new FormData();

            formData.append('slideId', this.slideEditId);
            formData.append('slideCommentary', this.slideEditComment);

            axios.post('/admin/saveSlideChanges', formData).then(response => {
                if(response.data === true){
                     this.$store.dispatch('getProject', {value: this.projectSlug, type: 'full'});
                    this.slideEditId = undefined;
                    this.slideEditComment = undefined;
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