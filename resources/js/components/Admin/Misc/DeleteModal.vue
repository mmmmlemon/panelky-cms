//DeleteModal
//модальное окно для удаления проекта
<template>
    <div class="deleteModalBody fadeInAnim" v-if="deleteModalInfo !== -1 && deleteModalInfo !== undefined">
        <div class="row justify-content-center">
            <!-- удаление проектов -->
            <div class="col-11 col-md-4 transparentCard deleteModalCard m-1" v-if="deleteModalInfo.type === 'project'">
                <div class="card-body">
                    <h2 class="card-title">Удаление проекта</h2>
                    <hr>
                    <h5 class="card-text">Вы действительно хотите удалить проект <b>{{deleteModalInfo.deleteInfo.project_title}}</b>? Это действие нельзя будет отменить.</h5>
                    <br>
                    <!-- кнопки -->
                    <div class="d-grid gap-2 d-md-block">
                        <!-- отмена -->
                        <button class="btn btn-secondary" type="button" v-on:click="cancel">
                            <span><i class="bi bi-x"></i></span>
                            <span>Нет, не хочу</span>
                        </button>
                        <!-- удаление -->
                        <button class="btn btn-danger" type="button" v-on:click="deleteProject">
                            <span><i class="bi bi-trash-fill"></i></span>
                            <span>Да, удалить</span>
                        </button>
                    </div>
                </div> 
            </div>
            <!-- удаление ссылок -->
            <div class="col-11 col-md-4 transparentCard deleteModalCard m-1" v-if="deleteModalInfo.type === 'link'">
                <div class="card-body">
                    <h2 class="card-title">Удаление ссылки</h2>
                    <hr>
                    <h5 class="card-text">Вы действительно хотите удалить ссылку <b>{{deleteModalInfo.link_title}}</b>? Это действие нельзя будет отменить.</h5>
                    <br>
                    <!-- кнопки -->
                    <div class="d-grid gap-2 d-md-block">
                        <!-- отмена -->
                        <button class="btn btn-secondary" type="button" v-on:click="cancel">
                            <span><i class="bi bi-x"></i></span>
                            <span>Нет, не хочу</span>
                        </button>
                        <!-- удаление -->
                        <button class="btn btn-danger" type="button" v-on:click="deleteLink">
                            <span><i class="bi bi-trash-fill"></i></span>
                            <span>Да, удалить</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    //данные
    computed: {
        //информация об удаляемом проекте
        deleteModalInfo: function(){
            return this.$store.state.AdminStates.deleteModalInfo;
        }
    },
    //методы
    methods: {
        //отмена, закрыть модальное окно
        cancel(){
            this.$store.dispatch('setDeleteModalInfo', undefined);
        },

        //удалить проект
        deleteProject(){
            let slug = this.deleteModalInfo.deleteInfo.slug;

            let formData = new FormData();
            formData.append("slug", slug);

            axios.post('/admin/deleteProject', formData).then(response => {
                //если запрос на удаление был отправлен со страницы homeProjects
                //то обновляем данные для этой страницы
                if(this.deleteModalInfo.page === 'homeProjects')
                {
                    this.$store.dispatch('getProjectsList');
                    this.$store.dispatch('setFirstProjectSlug')
                    this.$store.dispatch('setDeleteModalInfo', undefined);
                }
                //если запрос на удаление был отправлен со страницы allProjects
                //то обновляем данные для этой страницы
                else if(this.deleteModalInfo.page === 'allProjects')
                {
                    this.$store.dispatch('getAllProjects');
                    this.$store.dispatch('setDeleteModalInfo', undefined);
                }
            }).catch(error => {
                if(error.response.status === 422 || error.response.status === 500){ 
                        var errors = error.response.data;
                        this.$store.dispatch('setErrors', error.response.data.message);
                     }
            });
        },

        //удалить ссылку
        deleteLink(){
            let slug = this.deleteModalInfo.slug;

            let formData = new FormData();
            formData.append("slug", slug);

            axios.post('/admin/deleteLink', formData).then(response => {
                    this.$store.dispatch('getLinks');
                    this.$store.dispatch('setDeleteModalInfo', undefined);
            }).catch(error => {
                if(error.response.status === 422 || error.response.status === 500){ 
                        var errors = error.response.data;
                        this.$store.dispatch('setErrors', error.response.data.message);
                     }
            });
        }
    }
}
</script>