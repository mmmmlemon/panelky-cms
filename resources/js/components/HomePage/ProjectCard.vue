//ProjectCard
//Карточка для проектов
<template>
    <div class="row h-100 p-2 w-75 d-flex justify-content-center borderUnderline zIndex-1 projectCard" 
            v-bind:class="{'zeroOpacity': visible === false}" 
            v-scroll="handleScroll" :id="project.slug">
        
        <!-- ошибка -->
        <!-- <div class="col-10" v-if="project === false">
            <Error errorMessage="Не удалось загрузить информацию о проекте"/>
        </div> -->
        <div class="d-none d-md-block projectCardButtons fadeInAnimSlow" v-if="visible === true">
            <b class="projectButton left" @click="prevSlide">
                <i class="bi bi-chevron-left" v-if="slidePosition !== 0"></i>
            </b>
            <b class="projectButton right" @click="nextSlide">
                <i class="bi bi-chevron-right" v-if="slidePosition < numOfSlides"></i>
            </b>
        </div>
        <!-- КАРТОЧКА, ОПИСАНИЕ СЛЕВА -->
        <div v-if="type=='left' && project !== undefined && slidePosition === 0" class="row justify-content-center">
            <!-- для десктопа -->
            <div class="d-none d-md-block col-12 text-center textVertical p-5 transparentCard goUpCardAnim" 
                        v-bind:class="{'col-md-12': project.project_image === null, 
                                        'col-md-5': project.project_image !== null}"
                        v-if="visible === true">
                <!-- название проекта -->
                <h1 class="d-md-block d-sm-none text-center textVertical font3-8rem">
                    <b>{{project.project_title}}</b>
                </h1>
                <h1 class="d-md-none d-sm-block text-center textVertical font1-2rem">
                    <b>{{project.project_title}}fdfdf</b>
                </h1>
                <!-- лого -->
                <img v-if="project.project_icon !== null" 
                    :src="project.project_icon" class="projectLogo" alt="">
                <br>
                <!-- краткое описание -->
                <p v-if="project.project_subtitle !== null" 
                    class="text-center textVertical font2rem">
                    {{project.project_subtitle}}
                </p>
                <br>
                <!-- подробное описание -->
                <p v-if="project.project_desc !== null"
                    class="text-center font1-2rem">
                    {{project.project_desc}}
                </p>
                <hr>
                <!-- футер -->
                <h6 v-if="project.project_bottomText !== null"
                    class="text-center">
                    <b>{{project.project_bottomText}}</b>
                </h6>
                <br>
                <!-- кнопка "Посетить" -->
                <button v-if="project.project_url !== undefined && project.project_url !== ''" 
                        type="button" class="btn btn-lg btn-outline-light">
                    <a :href="project.project_url" target="_blank">
                        Перейти к проекту
                    </a>
                </button>
            </div>
            <!-- скриншот проекта -->
            <div class="d-none d-md-block col-12 col-md-6 text-center textVertical goLeftCardAnim" 
                 v-if="project.project_image !== null && visible === true">
                <img :src="project.project_image" :class="classForImage" alt="">
            </div>

            <!-- TODO для мобилок -->
            <div class="d-block d-md-none col-12 text-center textVertical goUpCardAnim" v-if="visible === true">
                <!-- название проекта -->
                <h1 class="text-center textVertical font3-2rem">
                    <b>{{project.project_title}}</b>
                </h1>
                <!-- лого -->
                <img :src="project.project_icon" class="projectLogo" alt="">
                <br>
                
                <!-- краткое описание -->
                <p class="text-center textVertical font1-2rem">{{project.project_subtitle}}</p>
                <hr v-if="project.project_bottomText !== null">
                <!-- футер -->
                <h6 v-if="project.project_bottomText !== null"
                    class="text-center">
                    <b>{{project.project_bottomText}}</b>
                </h6>
                <br>
                <!-- кнопка "Посетить" -->
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="project.project_url" target="_blank">
                        Перейти к проекту
                    </a>
                </button>
            </div>

        </div>

        <!-- КАРТОЧКА, ОПИСАНИЕ СПРАВА -->
        <div v-else-if="type=='right' && project !== undefined && slidePosition === 0" class="row justify-content-center">
            <!-- для десктопа -->

            <!-- скриншот проекта -->
            <div v-if="project.project_image !== null && visible === true"
                 class="d-none d-md-block col-12 col-md-6 text-center textVertical goRightCardAnim" >
                <img :src="project.project_image" :class="classForImage" alt="">
            </div>

            <div v-bind:class="{'col-md-12': project.project_image === null, 
                                'col-md-5': project.prokect_image !== null}"
                 v-if="visible === true"
                 class="d-none d-md-block col-12 text-center textVertical p-5 transparentCard goUpCardAnim">
                <!-- название проекта -->
                <h1 class="text-center textVertical font3-8rem">
                    <b>{{project.project_title}}</b>
                </h1>
                <!-- лого -->
                <img v-if="project.project_icon !== null" 
                    :src="project.project_icon" class="projectLogo" alt="">
                <br>
                <!-- краткое описание -->
                <p v-if="project.project_subtitle !== null"
                    class="text-center textVertical font2rem">
                    {{project.project_subtitle}}
                </p>
                <br>
                <!-- подробное описание -->
                <p v-if="project.project_desc !== null"
                    class="text-center font1-2rem">
                    {{project.project_desc}}
                </p>
                <hr>
                <!-- футер -->
                <h6 v-if="project.project_bottomText !== null"
                    class="text-center">
                    <b>{{project.project_bottomText}}</b>
                </h6>
                <br>
                <!-- кнопка "Посетить" -->
                <button v-if="project.project_url !== undefined && project.project_url !== ''"
                        type="button" class="btn btn-lg btn-outline-light">
                    <a :href="project.project_url" target="_blank">
                        Перейти к проекту
                    </a>
                </button>
            </div>

            <!-- TODO для мобилок -->
            <div class="d-block d-md-none col-12 text-center textVertical goUpCardAnim" v-if="visible === true">
                <!-- название проекта -->
                <h1 class="text-center textVertical font3-2rem">
                    <b>{{project.project_title}}</b>
                </h1>
                <!-- лого -->
                <img :src="project.project_icon" class="projectLogo" alt="">
                <br>
                
                <!-- краткое описание -->
                <p class="text-center textVertical font1-2rem">{{project.project_subtitle}}</p>
                <hr v-if="project.project_bottomText !== null">
                <!-- футер -->
                <h6 v-if="project.project_bottomText !== null"
                    class="text-center">
                    <b>{{project.project_bottomText}}</b>
                </h6>
                <br>
                <!-- кнопка "Посетить" -->
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="project.project_url" target="_blank">
                        Перейти к проекту
                    </a>
                </button>
            </div>
        </div>

        <div class="row justify-content-center" v-for="(slide, index) in project.slides" v-bind:key="index" v-bind:class="{'invisible': (index + 1) !== slidePosition}">
            <div class="d-none d-md-block col-12 text-center textVertical p-5 transparentCard" v-bind:class="slideAnimation">
                <a :href="slide.media_url"><img :src="slide.media_url" width="70%" alt=""></a>
                <hr>
                <h4>{{slide.commentary}}</h4>
            </div>
        </div>
        
    </div>
    
</template>
<script>
export default {

     mounted(){
        this.setVisible = this.isVisible;

        let img = new Image();
        img.src = this.project.project_image;
        img.onload = () => {

            if(img.width > img.height){
                this.classForImage = 'projectImageHorizontal';
            }
            else{
                this.classForImage = 'projectImageVertical';
            }
        }

    },

    //данные
    data: () => {
        return {
            //видимость карточки
            visible: false,
            classForImage: 'projectImageVertical',
            slidePosition: 0,
            slideAnimation: 'goLeftCardAnim',
        }
    },

    //данные
    props: {
        //тип карточки, "левая" или "правая"
        type: { type: String, default: 'left' },
        isVisible: { type: Boolean, default: true },
        //инф-ция о проекте
        project: {type: Object, default: function(){
            return {
                'project_title': undefined,
                'project_subtitle': undefined,
                'project_desc': undefined,
                'project_bottomText': undefined,
                'project_icon': undefined,
                'project_image': undefined,
                'project_url': undefined,
            }
        }},
    },

    computed: {
        //видимость карточки
        setVisible: {
           get() {
               this.visible = false;
           },
           set(value){
               this.visible = value;
           }
        },

        numOfSlides(){
            return this.project.slides.length;
        }
    },

    //методы
    methods: {
        //при скролле страницы показать карточку когда она будет 
        //в поле видимости
        handleScroll: function (evt, el){
            if (el.getBoundingClientRect().top < 300) {

                this.setVisible = true;
            }
            return el.getBoundingClientRect().top < 300;
            
        },

        prevSlide(){
            
            if(this.slidePosition - 1 >= 0)
            {   
                this.slideAnimation = "goRightCardAnim";
                this.slidePosition -= 1; 
            }
 
        },

        nextSlide(){
            if(this.slidePosition + 1 <= this.numOfSlides)
            { 
                this.slideAnimation = "goLeftCardAnim";
                this.slidePosition += 1; 
            }
        }
    }
}
</script>