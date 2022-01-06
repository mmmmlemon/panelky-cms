//About
//страница About
<template>
    <div class="row h-100 justify-content-center fadeInAnim mt-5 md-mt-0" v-if="about === 1">
       <div v-html="aboutSiteText" class="col-12 col-md-5 goUpAnim text-center p-4 p-md-0" 
            v-if="aboutSiteText !== -1 && aboutSiteText !== false">
        </div>
    </div>
</template>
<script>
export default {
    created(){
        this.$parent.currentTab = 'about';
    },

    beforeMount(){
        if(this.about !== 1)
        { 
            axios.get('/api/getHomeSettings').then(response => {
                if(response.data.about !== 1){
                    window.location.href="/"; 
                }
                else{
                    if(this.aboutSiteText === -1){
                        this.$store.dispatch('getAboutSiteText');
                    }  
                }
            }).catch(error => {
                //
            });

        }
        else
        { 
            if(this.aboutSiteText === -1){
                this.$store.dispatch('getAboutSiteText');
            }   
        }   
    },

    computed: {
        about: function(){
            return this.$parent.settings.about;
        },

        aboutSiteText: function(){
            return this.$store.state.GlobalStates.aboutSiteText;
        },
    }
}
</script>