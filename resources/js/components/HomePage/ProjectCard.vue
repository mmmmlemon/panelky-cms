//ProjectCard
//Карточка для проектов
<template>
    <div class="row h-100 p-2 w-75 d-flex justify-content-center borderUnderline zIndex-1 projectCard" 
            v-bind:class="{'zeroOpacity': visible === false}" 
            v-scroll="handleScroll" :id="project.slug">
        
        <!-- ошибка -->
        <div class="col-10" v-if="project === false">
            <Error errorMessage="Не удалось загрузить информацию о проекте"/>
        </div>

        <!-- КАРТОЧКА, ОПИСАНИЕ СЛЕВА -->
        <div v-if="type=='left' && project !== undefined" class="row justify-content-center">

            <!-- для десктопа -->
            <div class="d-none d-md-block col-12 text-center textVertical p-5 transparentCard goUpCardAnim" 
                        v-bind:class="{'col-md-12': project.project_image === null, 
                                        'col-md-5': project.project_image !== null}"
                        v-if="visible === true">
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
            <!-- скриншот проекта -->
            <div class="d-none d-md-block col-12 col-md-6 text-center textVertical goLeftCardAnim" 
                 v-if="project.project_image !== null && visible === true">
                <img :src="project.project_image" class="projectImage" alt="">
            </div>

            <!-- TODO для мобилок -->
            <div class="d-block d-md-none col-12 text-center textVertical goUpCardAnim" v-if="visible === true">
                <!-- название проекта -->
                <h1 class="text-center textVertical font3-8rem">
                    <b>{{project.project_title}}</b>
                </h1>
                <!-- лого -->
                <img :src="project.project_icon" class="projectLogo" alt="">
                <br>
                
                <!-- краткое описание -->
                <p class="text-center textVertical font2rem">{{project.project_subtitle}}</p>
                <br>
                <!-- скриншот проекта -->
                <div class="d-block d-md-none col-12 col-md-6 text-center textVertical">
                    <img src="/stock/spoti_mobile.png" class="projectImageMobile" alt="">
                </div>
                <!-- кнопка "Посетить" -->
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="project.project_url" target="_blank">
                        View project
                    </a>
                </button>
            </div>

        </div>
        
        <!-- КАРТОЧКА, ОПИСАНИЕ СПРАВА -->
        <div v-else-if="type=='right' && project !== undefined" class="row justify-content-center">
            <!-- для десктопа -->

            <!-- скриншот проекта -->
            <div v-if="project.project_image !== null && visible === true"
                 class="d-none d-md-block col-12 col-md-6 text-center textVertical goRightCardAnim" >
                <img :src="project.project_image" class="projectImage" alt="">
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
                <button v-if="project.project_url !== null"
                        type="button" class="btn btn-lg btn-outline-light">
                    <a :href="project.project_url" target="_blank">
                        Перейти к проекту
                    </a>
                </button>
            </div>

            <!-- TODO для мобилок -->
            <div class="d-block d-md-none col-12 text-center textVertical goUpCardAnim" v-if="visible === true">
                <!-- название проекта -->
                <h1 class="text-center textVertical font3rem">
                    <b>{{project.project_title}}</b>
                </h1>
                <!-- лого -->
                <img :src="project.project_icon" class="projectLogo" alt="">
                <br>
                <!-- краткое описание -->
                <p class="text-center textVertical font2rem">{{project.project_subtitle}}</p>
                <br>
                <div class="d-block d-md-none col-12 col-md-6 text-center textVertical">
                    <img src="/stock/mr_mobile.png" class="projectImageMobile" alt="">
                </div>
                <!-- кнопка "Посетить" -->
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="project.project_url" target="_blank">
                        View project
                    </a>
                </button>
            </div>
        </div>

        <div v-else class="textVertical">
            <Error errorMessage="Неверный параметр 'type'"/>
        </div>
    
    </div>
    
</template>
<script>
export default {

     mounted(){
        this.setVisible = this.isVisible;
    },

    //данные
    data: () => {
        return {
            //видимость карточки
            visible: false,
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
        }
    }
}
</script>