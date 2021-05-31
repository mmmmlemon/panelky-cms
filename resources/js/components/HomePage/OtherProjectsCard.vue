//OtherProjectsCard
//список других проектов
<template>

    <div class="row width90pc bigCard d-flex justify-content-center borderUnderline" id="other">
        <div class="d-block d-md-block col-12 textVertical fadeInAnim m-5 goUpCardAnim">
            <h3 class="text-center mb-5">Другие проекты</h3>
            <div class="row justify-content-center">
                <div v-for="project in projects" :key="project.slug" class="col-12 col-md-2 transparentCard m-1">
                     <div class="card-body text-center" v-if="project.project_icon !== null">
                        <h4 class="card-title text-center">
                            <a :href="project.project_url" target="_blank">
                                <b>{{project.project_title}}</b>
                            </a>
                            
                        </h4>
                        <img :src="project.project_icon" class="projectLogo" alt="">
                     </div>
                     <div v-else class="card-body text-center textVertical">
                        <h4 class="card-title text-center mt-3">
                            <a :href="project.project_url" target="_blank">
                                <b>{{project.project_title}}</b>
                            </a>
                        </h4>
                     </div>
                </div>
            </div>
         
        </div>
    </div>
</template>
<script>
export default {
    //данные
    props: {
        projects: { type: Array, default: undefined },
    },
}
</script>