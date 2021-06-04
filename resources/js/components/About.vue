//About
//страница About
<template>
    <div class="row h-50 justify-content-center" v-if="about === 1">
       <h1>About</h1>
    </div>
</template>
<script>
export default {

    beforeMount(){
        if(this.about !== 1)
        { window.location.href="/"; }
    },

    computed: {
        about: function(){
            return this.$parent.settings.about;
        }
    }
}
</script>