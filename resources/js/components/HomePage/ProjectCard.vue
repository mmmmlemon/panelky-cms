//ProjectCard
//Карточка для проектов
<template>
    <div class="row h-100 p-2 w-75 d-flex justify-content-center borderUnderline zIndex-1 projectCard zIndex5" 
            v-bind:class="{'zeroOpacity': visible === false}" 
            v-scroll="handleScroll" :id="project.slug">
        
        <!-- ошибка -->
        <div class="col-10" v-if="project === false">
            <Error errorMessage="Не удалось загрузить информацию о проекте"/>
        </div>

        <!-- кнопки переключения слайдов -->
        <div class="projectCardButtons fadeInAnimSlow" v-if="visible === true && project.slides.horizontal.length > 0 && screenOrientation === 'horizontal'">
            <b class="d-flex projectButton left pointer" @click="prevSlide">
                <i class="bi bi-chevron-left"></i>
            </b>
            <b class="d-flex projectButton right pointer" @click="nextSlide">
                <i class="bi bi-chevron-right"></i>
            </b>
        </div>


        <!-- "точки" для слайдов -->
        <div class="col-12 sliderMenu fadeInAnimSlow" v-if="numOfSlides !== 0 && visible === true"
            v-bind:class="{'font1vw': screenOrientation === 'horizontal', 'font2vh': screenOrientation === 'vertical'}">
            <div class="row justify-content-center">
                <a class="m-1 slideButton pointer" @click="changeCurrentSlidePosition(0)" 
                    v-if="(project.slides.horizontal.length > 0 && screenOrientation === 'horizontal') ||
                            project.slides.vertical.length > 0 && screenOrientation === 'vertical'">
                    <i v-if="slidePosition === 0" class="bi bi-circle-fill"></i>
                    <i v-if="slidePosition !== 0" class="bi bi-circle"></i>
                </a>
                <!-- "точки" для вертикальных слайдов -->
                <a class="m-1 slideButton pointer" v-for="index in (numOfSlides.vertical)" 
                    v-bind:key="'verticalDot_'+index" @click="changeCurrentSlidePosition(index)"
                    v-bind:class="{'invisible': screenOrientation !== 'vertical'}">
                    <i v-if="slidePosition === index" class="bi bi-circle-fill"></i>
                    <i v-if="slidePosition !== index" class="bi bi-circle"></i>
                </a>
                <!-- "точки" для горизонтальных слайдов -->
                <a class="m-1 slideButton pointer" v-for="index in (numOfSlides.horizontal)" 
                    v-bind:key="'horizontalDot_'+index" @click="changeCurrentSlidePosition(index)"
                    v-bind:class="{'invisible': screenOrientation !== 'horizontal'}">
                    <i v-if="slidePosition === index && screenOrientation == 'horizontal'" class="bi bi-circle-fill"></i>
                    <i v-if="slidePosition !== index && screenOrientation == 'horizontal'" class="bi bi-circle"></i>
                </a>
            </div>
        </div>
    
        <div v-if="project !== undefined && slidePosition === 0 && screenOrientation === 'horizontal'" class="row justify-content-center">
            <!-- скриншот проекта -->
            <div class="d-none d-md-block col-12 col-md-6 text-center textVertical goRightCardAnim" 
                 v-if="project.project_image !== null && visible === true && type == 'right'">
                <img :src="project.project_image" :class="classForImage" alt="">
            </div>
            <div class="col-12 text-center textVertical p-5 transparentCard goUpCardAnim" 
                v-touch:swipe.left="nextSlide" 
                v-touch:swipe.right="prevSlide"
                v-bind:class="{'col-md-12': project.project_image === null, 
                                'col-md-5': project.project_image !== null}"
                v-if="visible === true">
                
                <!-- название проекта -->
                <h1 class="unclickable d-md-block text-center textVertical font3vw">
                    <b>{{project.project_title}}</b>
                </h1>
                <!-- лого -->
                <img v-if="project.project_icon !== null" 
                    :src="project.project_icon" class="unclickable projectLogo m-2" alt="">
                <br>
                <!-- краткое описание -->
                <p v-if="project.project_subtitle !== null" 
                    class="unclickable text-center textVertical font1-5vw">
                    {{project.project_subtitle}}
                </p>
                <br>
                <!-- подробное описание -->
                <p v-if="project.project_desc !== null"
                    class="unclickable text-center font1vw">
                    {{project.project_desc}}
                </p>
                <hr>
                <!-- футер -->
                <h6 v-if="project.project_bottomText !== null"
                    class="unclickable text-center">
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
                 v-if="project.project_image !== null && visible === true && type == 'left'">
                <img :src="project.project_image" :class="classForImage" alt="">
            </div>

        </div>

        <div v-if="project !== undefined && slidePosition === 0 && screenOrientation === 'vertical'" class="row justify-content-center">
            <div class="col-12 text-center textVertical transparentCard p-4 goUpCardAnim" 
                v-touch:swipe.left="nextSlide" 
                v-touch:swipe.right="prevSlide"
                v-if="visible === true">
                <!-- название проекта -->
                <h1 class="text-center textVertical font8vw">
                    <b>{{project.project_title}}</b>
                </h1>
                <!-- лого -->
                <img :src="project.project_icon" class="projectLogo m-2" alt="">
                <br>
                
                <!-- краткое описание -->
                <p class="text-center textVertical font4vw">{{project.project_subtitle}}</p>
                <hr v-if="project.project_bottomText !== null">
                <!-- футер -->
                <h6 v-if="project.project_bottomText !== null"
                    class="text-center font3vw">
                    <b>{{project.project_bottomText}}</b>
                </h6>
                <br>
                <!-- кнопка "Посетить" -->
                <button type="button" class="btn btn-lg btn-outline-light font4vw">
                    <a :href="project.project_url" target="_blank">
                        Перейти к проекту
                    </a>
                </button>
            </div>
        </div>

        <!-- СЛАЙДЫ -->
        <!-- вертикальные слайды -->
        <div class="slideVerticalImage justify-content-center textVertical"
             v-touch:swipe.left="nextSlide" 
             v-touch:swipe.right="prevSlide"
             v-for="(slide, index) in project.slides.vertical" 
             v-bind:key="'vertical_'+slide.id" 
             v-bind:class="{'invisible': (index + 1) !== slidePosition || screenOrientation !== 'vertical', 
                            [''+slideAnimation]: (index + 1) === slidePosition}">
            <!-- текст комментария к слайду -->
            <transition name="slideCommentary">
                <div class="slideTextVertical unclickable d-flex align-items-center text-center justify-content-center fadeInAnim" 
                    v-if="slideCommentaryVisibility === true && slide.commentary !== null">
                    <h4 class="font5vw">{{slide.commentary}}</h4>
                </div>
            </transition>

            <div class="d-block text-center">
               <!-- изображение -->
               <div class="slideImage" v-bind:style="{backgroundImage: 'url(' + slide.media_url + ')'}">
                   <a class="slideFullscreenButton vertical" target="_blank" :href="slide.media_url">
                       <i class="bi bi-arrows-fullscreen"></i>
                    </a>
               </div>
               <!-- кнопка показать\скрыть комментарий -->
               <b class="btn-block slideShowCommentaryButton" v-if="slide.commentary !== null" @click="toggleSlideCommentaryVisibility">
                    <transition name="slideCommentaryButton" mode="out-in">
                        <span key="show" v-if="slideCommentaryVisibility === false">
                            <i class="bi bi-info-circle"></i>
                        </span>
                        <span key="hide" v-if="slideCommentaryVisibility === true">
                            <i class="bi bi-x"></i>
                        </span>
                    </transition>
               </b>
            </div>
        </div> 
        <!-- горизонтальные слайды -->
        <div class="slideHorizontalImage justify-content-center textVertical"
             v-touch:swipe.left="nextSlide" 
             v-touch:swipe.right="prevSlide"
             v-for="(slide, index) in project.slides.horizontal" 
             v-bind:key="'horizontal_'+slide.id" 
             v-bind:class="{'invisible': (index + 1) !== slidePosition || screenOrientation !== 'horizontal', 
                            [''+slideAnimation]: (index + 1) === slidePosition}">
            <div class="d-block text-center" >
               <!-- изображение -->
               <div class="slideImage" v-bind:style="{backgroundImage: 'url(' + slide.media_url + ')'}">
                    <a class="slideFullscreenButton horizontal" target="_blank" :href="slide.media_url">
                       <i class="bi bi-arrows-fullscreen"></i>
                    </a>
                   <!-- текст комментария -->
                   <div v-if="slide.commentary !== null" class="slideTextHorizontal unclickable d-flex align-items-center text-center justify-content-center w-100">
                        <h4>{{slide.commentary}}</h4>
                   </div>
               </div>
            </div>
        </div> 
    
    </div>
    
</template>
<script>
export default {

    created(){
        window.addEventListener("resize", this.setSlidePositionOnWindowResize);
    },

    mounted(){
        this.setVisible = this.isVisible;

        // определяем подходящий класс для скриншота проекта
        let projectImage = new Image();
        projectImage.src = this.project.project_image;
        projectImage.onload = () => {
            if(projectImage.width > projectImage.height){
                this.classForImage = 'projectImageHorizontal';
            }
            else{
                this.classForImage = 'projectImageVertical';
            }
        };
        
        if(this.$parent.settings !== undefined){
            let headerCardVisiblity = this.$parent.settings.site_owner;
            if(headerCardVisiblity === 0){
                if(this.project.id === this.$parent.fullProjectList.home[0].id)
                { this.setVisible = true; }
            }
        } 
    },

    beforeDestroy() {
        window.removeEventListener("resize", this.setSlidePositionOnWindowResize);
    },

    //данные
    data: () => {
        return {
            //видимость карточки
            visible: false,
            // класс для скриншота проекта
            classForImage: 'projectImageVertical',
            // классы для слайдов
            classesForSlides: {},
            // текущая позиция слайда
            slidePosition: 0,
            slidePosition: 0,
            // анимация для слайда
            slideAnimation: 'goLeftSlideAnim',
            slideCommentaryVisibility: false,
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

        // кол-во слайдов в проекте
        numOfSlides(){
           return {'vertical': this.project.slides.vertical.length,
                    'horizontal': this.project.slides.horizontal.length };
        },

        //ориентация экрана
        screenOrientation(){
            return this.$store.state.GlobalStates.screenOrientation;
        },
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
        
        // перейти к предыдущему слайду
        prevSlide(){
            let conditionVertical = this.screenOrientation === 'vertical' && (this.slidePosition - 1 >= 0);
            let conditionHorizontal = this.screenOrientation === 'horizontal' && (this.slidePosition - 1 >= 0);

            if(conditionVertical || conditionHorizontal)
            {   
                this.slideAnimation = "goRightSlideAnim";
                this.slidePosition -= 1; 
            }
            else{
                this.slideAnimation = "goRightSlideAnim";
                if(this.screenOrientation === 'vertical')
                { this.slidePosition = this.numOfSlides.vertical; }
                else if (this.screenOrientation === 'horizontal')
                { this.slidePosition = this.numOfSlides.horizontal; }
            }
        },

        // перейти к следующему слайду
        nextSlide(){
            let conditionVertical = this.screenOrientation === 'vertical' && (this.slidePosition + 1 <= this.numOfSlides.vertical);
            let conditionHorizontal = this.screenOrientation === 'horizontal' && (this.slidePosition + 1 <= this.numOfSlides.horizontal);

            if(conditionVertical || conditionHorizontal)
            { 
                this.slideAnimation = "goLeftSlideAnim";
                this.slidePosition += 1; 
            } else {
                this.slideAnimation = "goLeftSlideAnim";
                this.slidePosition = 0;
            }
        },

        // переключить на выбранный слайд при нажатии на "точку"
        changeCurrentSlidePosition(index){
            this.slidePosition = index;
        },

        toggleSlideCommentaryVisibility(index){
            this.slideCommentaryVisibility = !this.slideCommentaryVisibility;
        },

        // изменить позицию слайда при смене ориентации экрана, если это нужно
        setSlidePositionOnWindowResize(){
            let width = window.innerWidth;
            let height = window.innerHeight;

            if(width > height){
                if(this.project.slides.horizontal.length < this.slidePosition)
                { this.slidePosition = this.project.slides.horizontal.length; }
            }
            else if (height > width){
               if(this.project.slides.vertical.length < this.slidePosition)
                { this.slidePosition = this.project.slides.vertical.length; }
            }
        }
    }
}
</script>