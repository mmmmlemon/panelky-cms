// EditSlideCommentary
// редактировать комментарий к слайду
<template>

</template>
<script>
export default {

    props: {
        slideIndex: {default: undefined, type: Number}
    },


    computed: {
        slideCommentary(){
            if(slideIndex !== undefined)
            {
                return this.$parent.projectSlidesHorizontal[slideIndex];
            }      
        }   
    }
}
</script>