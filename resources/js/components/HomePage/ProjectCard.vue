//ProjectCard
//Карточка для проектов
<template>

    <div class="row h-100 p-2 w-75 d-flex justify-content-center borderUnderline zIndex-1">

        <div class="col-10" v-if="project === false">
            <Error errorMessage="Не удалось загрузить информацию о проекте"/>
        </div>

        <!-- карточка с описанием слева -->
        <div v-if="type=='left' && project !== undefined" class="row justify-content-center">
            <!-- для десктопа -->
            <div class="d-none d-md-block col-12 col-md-5 text-center textVertical">
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
                <!-- подробное описание -->
                <p class="text-center font1-2rem">{{project.project_desc}}</p>
                <hr>
                <!-- футер -->
                <h6 class="text-center"><b>{{project.project_bottomText}}</b></h6>
                <br>
                <!-- кнопка "Посетить" -->
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="project.project_url" target="_blank">
                        View project
                    </a>
                </button>
            </div>
            <!-- скриншот проекта -->
            <div class="d-none d-md-block col-12 col-md-6 text-center textVertical">
                <img :src="project.project_image" class="projectImage" alt="">
            </div>

            <!-- для мобилок -->
            <div class="d-block d-md-none col-12 text-center textVertical">
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
        
        <!-- карточка с описанием справа -->
        <div v-else-if="type=='right'" class="row justify-content-center">
            <!-- для десктопа -->
            <!-- скриншот проекта -->
            <div class="d-none d-md-block col-12 col-md-6 text-center textVertical">
                <img :src="project.project_image" class="projectImage" alt="">
            </div>
            <div class="d-none d-md-block col-12 col-md-5 text-center textVertical">
                <h1 class="text-center textVertical font3-2rem">
                    <b>{{project.project_title}}</b>
                </h1>
                <img :src="project.project_icon" class="projectLogo" alt="">
                <br>
                <p class="text-center textVertical font2rem">{{project.project_subtitle}}</p>
                <br>
                <p class="text-center font1-2rem">{{project.project_desc}}</p>
                <hr>
                <h6 class="text-center"><b>{{project.project_bottomText}}</b></h6>
                <br>
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="project.project_url" target="_blank">
                        View project
                    </a>
                </button>
            </div>

            <!-- для мобилок -->
            <div class="d-block d-md-none col-12 text-center textVertical">
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

    //данные
    props: {
        type: { type: String, default: 'left' },
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
}
</script>