//ProjectListItem
//проект в списке проектов
<template>
    <div class="col-12 col-md-11 m-1 fadeInAnim pl-2 pr-2" v-on:mousedown="getProject(slug)"
                                       v-if="currentProjectSlug !== undefined">
        <div class="col-12 transparentCard m-1 p-0"  v-bind:class="{ active: slug === currentProjectSlug }" >
            <div class="card-body p-3">
                <!-- название -->
                <h2 class="card-title text-right">
                    {{title}}
                </h2>
                <hr>
                <!-- кнопка перемещения в списке -->
                <div class="row ">
                    <div class="col-12">
                        <button class="btn btn-light float-right backgroundAnimation handle" type="button">
                                <i class="bi bi-arrows-move"></i>
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
    props: {
        slug: { type: String, default: undefined },
        title: { type: String, default: "Title"}
    },

    computed: {
        //slug текущего выбранного проекта
        currentProjectSlug: function(){
            return this.$store.state.AdminStates.currentProject.slug;
        }
    },

    //методы
    methods: {
        getProject: function(value){
            this.$store.dispatch('getProject', {value: value, type: 'mini'});
            this.$store.dispatch('setCurrentProjectSlug', value);
        }
    }
}
</script>