//Projects
//вкладка в админке, список проектов
<template>
   <div class="row mt-5 justify-content-center fadeInAnim">

       <div class="col-12 m-3">
           <div class="row justify-content-center">
                <PreviewProject type="mini" :projectInfo="{name:'SpotiFYI', 'icon': '/stock/spoti_logo.png', 'subtitle': 'Music statistics for Spotify'}"/>
           </div>

       </div>

        <div class="col-12 m-3">
            <div class="row justify-content-center">
                <PreviewProject type="mini" :projectInfo="{name:'Weird Web-Site of [Mr. o_O]', 'icon': '/stock/mr_logo.png', 'subtitle': 'Videoblog page'}"/>
            </div>
        </div>

        
    </div>
</template>

<script>
export default {
    
    beforeMount(){
        this.$store.dispatch('setCurrentTab', 'projects');
    },
    
}
</script>