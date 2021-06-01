//LinkItem
//ссылка в форме

<template>
    <form method="POST" @submit.prevent="submit()">
        <div class="row justify-content-center">
            <div class="col-2 text-center">
                <h6>&nbsp;</h6>
                <h4>{{link.link_title}}</h4>
            </div>
            <div class="col-3 mb-3">
                <h6>Название ресурса</h6>
                <input type="text" class="form-control" placeholder="Twitter" 
                        v-model="link.link_title"
                        :name="link.slug" required>
                <div v-if="errors && errors.link_title" class="text-danger goUpAnim">{{ errors.link_title[0] }}</div>
            </div>
            <div class="col-4 mb-3">
                <h6>URL</h6>
                <input type="text" class="form-control" placeholder="https://twitter.com/username" 
                       v-model="link.link_url" required>
                <div v-if="errors && errors.link_url" class="text-danger goUpAnim">{{ errors.link_url[0] }}</div>
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
    </form>
</template>
<script>
export default {
    //данные
    data: () => {
        return {
            errors: null,
        }
    },

    props: {
        link: { type: Object, default: function(){
            return {
                id: undefined,
                link_title: undefined,
                link_url: undefined,
                slug: undefined,
            }
        }}
    },

    //методы
    methods: {
        submit(){
            
            let formData = new FormData();

            formData.append('id', this.link.id);
            formData.append('link_title', this.link.link_title);
            formData.append('link_url', this.link.link_url);

            axios.post('/admin/editLink', formData).then(response => {
                //
            }).catch(error => {
                if(error.response.status === 422){ 
                    this.errors = error.response.data.errors || {};
                }
            });
        }
    }
}
</script>