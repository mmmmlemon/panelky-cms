//ProjectListItem
//проект в списке проектов
<template>
    <div class="col-11 m-1 transparentCard" v-on:click="getProject(id)" v-bind:class="{ active: id === currentProjectId }">
        <div class="row">
            <div class="col-10 text-center align-middle">
                <h2 class="" style="margin-top:10%;">{{title}}</h2>
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
    
    props: {
        id: { type: Number, default: undefined },
        title: { type: String, default: "Title"}
    },

    computed: {
        currentProjectId: function(){
            return this.$store.state.AdminStates.currentProjectId;
        }
    },

    methods: {
        getProject: function(value){
            this.$store.dispatch('getProject', {value: value, type: 'mini'});
            this.$store.dispatch('setCurrentProjectId', value);
        }
    }



}
</script>