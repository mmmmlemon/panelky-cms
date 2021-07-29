// EditProjectSlides.vue
// редактирование слайдов проекта
<template>
    <!-- форма для картинок -->
    <form  class="fadeInAnim" method="POST">
        <!-- Лого\иконка -->
        <div class="mb-3">
            <h6>Скриншот, gif или короткое видео проекта</h6>
            <input type="file" ref="icon" class="form-control-file"
                    accept="image/jpeg, image/png, image/gif, video/mp4,video/x-m4v,video/*">
            <!-- <div v-if="errors && errors.projectIcon" class="text-danger">{{ errors.projectIcon[0] }}</div> -->
            <a class="btn btn-sm btn-light mt-3">Удалить медиа</a>
        </div>
        <div class="mb-3">
            <h6>Комментарий</h6>
            <input type="text" placeholder="Комментарий к слайду" class="form-control">
            <!-- <div v-if="errors && errors.project_title" class="text-danger goUpAnim">{{ errors.project_title[0] }}</div> -->
        </div>
        <button class="btn btn-lg btn-block btn-outline-light">
            Загрузить и сохранить
        </button>
    </form>
</template>
<script>
export default {
    
}
</script>