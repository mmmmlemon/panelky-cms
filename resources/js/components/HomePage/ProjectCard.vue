// ProjectCard
// Карточка для проекта
<template>
    <div style="z-index: -1;" class="h-75 w-75 bigCard d-flex justify-content-center row borderUnderline">
        <div class="row justify-content-center" v-if="type=='left'">
            <div class="col-12 col-md-5 text-center textVertical">
                <h1 class="text-center textVertical">
                    <b>{{appName}}</b>
                </h1>
                <br>
                <p class="text-center textVertical font14pt">{{appDescription}}</p>
                <br>
                <p class="text-center">{{fullDescription}}</p>
                <hr>
                <h6 class="text-center"><b>{{footer}}</b></h6>
                <br>
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="appUrl" target="_blank">
                        View project
                    </a>
                </button>
            </div>
            <div class="col-12 col-md-6 text-center textVertical">
                <img src="/stock/spoti.png" class="projectImage" alt="">
            </div>
        </div>
        <div class="row justify-content-center" v-else-if="type=='right'">
            <div class="col-12 col-md-6 text-center textVertical">
                <img src="/stock/mr.png" class="projectImage" alt="">
            </div>
            <div class="col-12 col-md-5 text-center textVertical">
                <h1 class="text-center textVertical">
                    <b>{{appName}}</b>
                </h1>
                <br>
                <p class="text-center textVertical font14pt">{{appDescription}}</p>
                <br>
                <p class="text-center">{{fullDescription}}</p>
                <hr>
                <h6 class="text-center"><b>{{footer}}</b></h6>
                <br>
                <button type="button" class="btn btn-lg btn-outline-light">
                    <a :href="appUrl" target="_blank">
                        View project
                    </a>
                </button>
            </div>
        </div>
        <div v-else>

        </div>
    </div>
</template>
<script>
export default {

    props: {
        type: { type: String, default: 'left' },
        appName: { type: String, default: 'App Name' },
        appUrl: { type: String },
        appDescription: { type: String, default: 'App description' },
        fullDescription: { type: String },
        footer: { type: String, default: 'Footer text' },
    },
}
</script>