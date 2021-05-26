//DeleteModal
//модальное окно для удаления проекта
<template>
    <div class="deleteModalBody fadeInAnim" v-if="deleteModalInfo !== -1 && deleteModalInfo !== undefined">
        <div class="row justify-content-center">
            <div class="col-4 transparentCard deleteModalCard m-1">
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
                //TODO
                //добавить ошибку в AppAdmin
            });
        }
    }
}
</script>