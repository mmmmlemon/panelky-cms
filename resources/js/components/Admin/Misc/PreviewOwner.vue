//Preview
//компонент для показа превью карточек
<template>
    <div class="col-12 fadeInAnim">  
      
        <!-- мини-превью -->
        <div class="col-12 d-flex justify-content-center previewCard" v-bind:style="animatedBackground" v-bind:class="{zeroOpacity: siteOwnerInfo === undefined}">
            <HeaderCard :info="siteOwnerInfo" />
            
            <!-- кнопка развернуть на весь экран -->
            <button class="btn btn-light fullscreenButton" title="Развернуть на полный экран" v-on:click="showFullscreenPreview">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>
        </div>

        <!-- превью на весь экран -->
        <div class="container col-12 vh-100 fullscreenCard" :style="fullscreenStyle">
            <button class="btn btn-light btn-lg fullscreenButton" title="Развернуть на полный экран" v-on:click="closeFullscreenPreview">
                <i class="bi bi-fullscreen-exit"></i>
            </button>
            <div class="row h-100 justify-content-center">
                <HeaderCard :info="siteOwnerInfo" /> 
            </div>
        </div>

    </div>
</template>
<script>
export default {
    
    //данные
    data: function(){
        return {
            fullscreenStyle: undefined,
        }
    },

    props: {
        siteOwnerInfo: { type: Object, default: function(){
            return {
                name: undefined,
                occupation: undefined,
                aboutMe: undefined,
                bottomText: undefined,
            }
        }},
    },

    computed: {
        animatedBackground: function(){
            return this.$store.state.AdminStates.animatedBackground;
        }
    },

    methods: {
        //показать превью на полный экран
        showFullscreenPreview: function(){
            this.fullscreenStyle = { left: '0px', opacity: 1 };
            this.fullscreenStyle.background = this.animatedBackground.background;
            this.fullscreenStyle.backgroundSize =  this.animatedBackground.backgroundSize;
            this.fullscreenStyle.backgroundRepeat = this.animatedBackground.backgroundRepeat;
        },

        //скрыть превью на полный экран
        closeFullscreenPreview: function(){
            this.fullscreenStyle.left = '5000px';
            this.fullscreenStyle.opacity = 0;
        }
    }
}
</script>