//ListOfProjects
//список проектов
<template>
    <div class="row" v-if="projectsList !== -1">
        <draggable v-model="projectsList" handle=".handle" v-bind="dragOptions" class="col-12 p-0">
                <div class="col-12" v-for="element in projectsList" :key="element.slug">
                    <ProjectListItem :slug="element.slug"
                        :title="element.title"/>
                </div>
        </draggable>    
    </div>
</template>
<script>
export default {
    //данные
    computed: {
        //список проектов
        projectsList: {
            get(){
                return this.$store.state.AdminStates.projectsList; 
            },

            set(value){
                let formData = new FormData();

                formData.append('newOrder', JSON.stringify(value));
                this.$store.commit('setState', {state: 'projectsList', value: value});
                axios.post('/admin/setNewOrderForHomeProjects', formData).then(response => {
                    //
                }).catch(error => {
                    this.$store.dispatch('setErrors', error.response.data.message);
                });
            }
        },

        dragOptions() {
            return {
                ghostClass: "dragGhost"
            }
        },
    },
}
</script>