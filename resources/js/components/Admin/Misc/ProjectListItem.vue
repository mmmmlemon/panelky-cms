//ProjectListItem
//проект в списке проектов
<template>
    <div class="col-11 m-1 fadeInAnim" v-on:click="getProject(slug)"
                                                        v-if="currentProjectSlug !== undefined">
        <!-- <div class="row">
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
        </div>     -->

        <div class="col-12 transparentCard m-1 p-0"  v-bind:class="{ active: slug === currentProjectSlug }" >
            <div class="card-body p-3">
                <h2 class="card-title text-right">{{title}}</h2>
                <hr>
                <!-- <p class="card-text">{{project.project_subtitle}}</p> -->
                <div class="row ">
                    <div class="col-12" v-if="$parent.projectsList.length > 1">
                        <button class="btn btn-light float-right backgroundAnimation" type="button">
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