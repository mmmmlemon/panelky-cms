<template>
    <div>

        <transition-group name="other" v-if="visible" tag="div">
            <div v-for="(project,i) in fullProjectList.other" :key="project.slug" class="other-item" :style="`transition-delay: ${i/5}s;`">
                <h3>{{project.project_title}}</h3>
            </div>
        </transition-group>

    </div>
</template>
<script>
export default {
    mounted(){

        this.$store.dispatch('getFullProjectList');
        this.visible = true;
    },

    data: () => {
        return{
            visible: false,
        }
    },

    computed: {
        
        //полный список проектов
        fullProjectList: function(){
            return this.$store.state.GlobalStates.fullProjectList;
        },

    }
}
</script>