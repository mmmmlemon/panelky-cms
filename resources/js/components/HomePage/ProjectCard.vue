// ProjectCard
// Карточка для проекта
<template>
    <div style="z-index: -1;" class="row h-75 w-75 d-flex justify-content-center borderUnderline">
        <!-- карточка с описанием слева -->
        <div v-if="type=='left'" class="row justify-content-center">
            <!-- для десктопа -->
            <div class="d-none d-md-block col-12 col-md-5 text-center textVertical">
                <!-- название проекта -->
                <h1 class="text-center textVertical font3-8rem">
                    <b>{{projectName}}</b>
                </h1>
                <!-- лого -->
                <img src="/stock/spoti_logo.png" class="projectLogo" alt="">
                <br>
                <!-- краткое описание -->
                <p class="text-center textVertical font2rem">{{projectDescription}}</p>
                <br>
                <!-- подробное описание -->
                <p class="text-center font1-2rem">{{fullDescription}}</p>
                <hr>
                <!-- футер -->
                <h6 class="text-center"><b>{{footer}}</b></h6>
                <br>
                <!-- кнопка "Посетить" -->
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="projectUrl" target="_blank">
                        View project
                    </a>
                </button>
            </div>
            <!-- скриншот проекта -->
            <div class="d-none d-md-block col-12 col-md-6 text-center textVertical">
                <img src="/stock/spoti.jpg" class="projectImage" alt="">
            </div>

            <!-- для мобилок -->
            <div class="d-block d-md-none col-12 text-center textVertical">
                <!-- название проекта -->
                <h1 class="text-center textVertical font3-8rem">
                    <b>{{projectName}}</b>
                </h1>
                <!-- лого -->
                <img src="/stock/spoti_logo.png" class="projectLogo" alt="">
                <br>
                
                <!-- краткое описание -->
                <p class="text-center textVertical font2rem">{{projectDescription}}</p>
                <br>
                <!-- скриншот проекта -->
                <div class="d-block d-md-none col-12 col-md-6 text-center textVertical">
                    <img src="/stock/spoti_mobile.png" class="projectImageMobile" alt="">
                </div>
                <!-- кнопка "Посетить" -->
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="projectUrl" target="_blank">
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
                <img src="/stock/mr.jpg" class="projectImage" alt="">
            </div>
            <div class="d-none d-md-block col-12 col-md-5 text-center textVertical">
                <h1 class="text-center textVertical font3-2rem">
                    <b>{{projectName}}</b>
                </h1>
                <img src="/stock/mr_logo.png" class="projectLogo" alt="">
                <br>
                <p class="text-center textVertical font2rem">{{projectDescription}}</p>
                <br>
                <p class="text-center font1-2rem">{{fullDescription}}</p>
                <hr>
                <h6 class="text-center"><b>{{footer}}</b></h6>
                <br>
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="projectUrl" target="_blank">
                        View project
                    </a>
                </button>
            </div>

            <!-- для мобилок -->
            <div class="d-block d-md-none col-12 text-center textVertical">
                <!-- название проекта -->
                <h1 class="text-center textVertical font3rem">
                    <b>{{projectName}}</b>
                </h1>
                <!-- лого -->
                <img src="/stock/mr_logo.png" class="projectLogo" alt="">
                <br>
                <!-- краткое описание -->
                <p class="text-center textVertical font2rem">{{projectDescription}}</p>
                <br>
                <div class="d-block d-md-none col-12 col-md-6 text-center textVertical">
                    <img src="/stock/mr_mobile.png" class="projectImageMobile" alt="">
                </div>
                <!-- кнопка "Посетить" -->
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="projectUrl" target="_blank">
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

    props: {
        type: { type: String, default: 'left' },
        projectName: { type: String, default: 'project Name' },
        projectUrl: { type: String },
        projectDescription: { type: String, default: 'project description' },
        fullDescription: { type: String },
        footer: { type: String, default: 'Footer text' },
    },
}
</script>