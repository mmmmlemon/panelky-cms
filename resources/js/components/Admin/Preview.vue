//Preview
//компонент для показа превью карточек
<template>
    <div class="col-12 col-md-6">  
        
        <!-- мини-превью -->
        <div class="col-12 d-flex m-5 justify-content-center animatedBackground previewCard">
            <HeaderCard :info="{name: name, occupation: occupation, aboutMe: aboutMe, bottomText: bottomText}" />
            
            <!-- кнопка развернуть на весь экран -->
            <button class="btn btn-light fullscreenButton" title="Развернуть на полный экран" v-on:click="showFullscreenPreview">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>
        </div>

        <!-- превью на весь экран -->
        <div class="container col-12 vh-100 animatedBackground fullscreenCard" :style="fullscreenStyle">
            <button class="btn btn-light btn-lg fullscreenButton" title="Развернуть на полный экран" v-on:click="closeFullscreenPreview">
                <i class="bi bi-fullscreen-exit"></i>
            </button>
            <div class="row h-100 justify-content-center">
                <HeaderCard :info="{name: name, occupation: occupation, aboutMe: aboutMe, bottomText: bottomText}" /> 
            </div>
        </div>

    </div>
</template>
<script>
export default {

    data: function(){
        return {
            fullscreenStyle: undefined,
        }
    },

    props: {
        name: '',
        occupation: '',
        aboutMe: '',
        bottomText: '',
    },

    methods: {
        //показать превью на полный экран
        showFullscreenPreview: function(){

            this.fullscreenStyle = { left: '0px', opacity: 1 };
        },

        //скрыть превью на полный экран
        closeFullscreenPreview: function(){
            this.fullscreenStyle = { left: '5000px', opacity: 0 };
        }
    }
}
</script>