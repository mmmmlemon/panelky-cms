//PreviewProject
//превью проекта
<template>
    <div class="col-12 col-md-4 text-center">
        <div v-if="type === 'mini'" class="col-12 projectMiniPreview animatedBackground">
            <!-- название проекта -->
            <h1 class="text-center textVertical font3-8rem">
                <b>{{projectInfo.title}}</b>
            </h1>
            <!-- лого -->
            <img :src="projectInfo.icon" class="projectLogo" alt="">
            <br>
            <!-- краткое описание -->
            <p class="text-center textVertical font2rem">{{projectInfo.subtitle}}</p>
            <hr>
            <button class="btn btn-lg btn-light m-2" title="Редактировать">
                <i class="bi bi-pencil-fill"></i>
            </button>
            <button class="btn btn-lg btn-light m-2" title="Удалить">
                <i class="bi bi-trash-fill"></i>
            </button>
        </div>
        <div v-else-if="type === 'full'" class="col-12">
            <h2>Full Project Preview</h2>
        </div>
        <div v-else>
            <Error errorMessage="Неверный параметр 'type'"/>
        </div>
    </div>
</template>

<script>
export default {
    
    props: {
        type: { type: String, default: 'mini' },
        projectInfo: { type: Object, default: function() {
            return {
                'title': undefined,
                'icon': undefined,
                'subtitle': undefined,
                'id': undefined,
            }
        }}
    }

}
</script>
