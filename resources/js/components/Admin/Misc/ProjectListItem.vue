//ProjectListItem
//проект в списке проектов
<template>
    <div class="col-11 m-1 fadeInAnim transparentCard" v-on:click="getProject(slug)" v-bind:class="{ active: slug === currentProjectSlug }" 
                                                        v-if="currentProjectSlug !== undefined">
        <div class="row">
            <div class="col-10 text-center align-middle">
                <h2 style="margin-top:10%;">{{title}}</h2>
            </div>      
            <div class="col-2">
                <div class="row">
                    <div class="col-12 mt-4 mb-4">
                        <button class="btn" style="color: white;">
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