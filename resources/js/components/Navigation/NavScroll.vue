//NavScroll
//кнопка проматывающая наверх
<template>

    <button class="navScroll" :style="navScrollStyle" v-on:click="scrollToTop">
        <i class="bi bi-arrow-bar-up"></i>
    </button>

</template>

<script>
export default {
    
    props: {
        navScrollStyle: { type: Object, default: function(){ return {opacity: 0, zIndex: '-9999999'} }  },
    },

    methods: {
        scrollToTop: function() {
            window.scrollTo(0,0);
        },
    }
}
</script>