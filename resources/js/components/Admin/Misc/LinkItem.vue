//LinkItem
//ссылка в форме

<template>
    <div class="row justify-content-center">
        <div class="col-2 text-center">
            <h6>&nbsp;</h6>
            <h4>{{link.link_title}}</h4>
        </div>
        <div class="col-3 mb-3">
            <h6>Название ресурса</h6>
            <input type="text" class="form-control" placeholder="Twitter" 
                    v-model="link.link_title"
                     :name="link.link_slug" required>
            <!-- <div v-if="errors && errors.name" class="text-danger goUpAnim">{{ errors.name[0] }}</div> -->
        </div>
        <div class="col-4 mb-3">
            <h6>URL</h6>
            <input type="text" class="form-control" placeholder="https://twitter.com/username" 
                    :value="link.link_url" required>
            <!-- <div v-if="errors && errors.name" class="text-danger goUpAnim">{{ errors.name[0] }}</div> -->
        </div>
        <div class="col-3 mb-3">
            <h6>&nbsp;</h6>
            <!-- кнопка переместить ссылку -->
            <button class="btn btn-light" title="Переместить" >
                <i class="bi bi-arrows-move"></i>
            </button>
            <!-- кнопка удалить ссылку -->
            <button class="btn btn-light ml-2" title="Удалить ссылку">
                <i class="bi bi-trash-fill"></i>
            </button>
            <!-- кнопка удалить ссылку -->
            <button class="btn btn-light ml-2" title="Сохранить изменения">
                Сохранить
            </button>
        </div>

    </div> 
</template>
<script>
export default {
    //данные
    props: {
        link: { type: Object, default: function(){
            return {
                id: undefined,
                link_title: undefined,
                link_url: undefined,
                link_slug: undefined,
            }
        }}
    }
}
</script>