//SiteOwnerAbout.vue
//О сайте, настройки
<template>
    <div class="row justify-content-center fadeInAnim"> 
        <div class="col-10 p-0">
            <div class="row justify-content-center">
            <!-- форма редактирования -->
            <div class="col-12 col-md-10 mt-2 fadeInAnim" v-bind:class="{'zeroOpacity': siteOwnerInfo === -1}">
                <h5>О сайте</h5>
                <hr>
                <form @submit.prevent="submit" method="POST">
                    <!-- о себе -->
                    <div class="mb-3">
                        <textarea class="form-control" required rows="10"></textarea>
                        <!-- <div v-if="errors && errors.aboutMe" class="text-danger goUpAnim">{{ errors.aboutMe[0] }}</div> -->
                    </div>
                    <button class="btn btn-lg btn-block btn-outline-light">
                        Сохранить
                    </button>
                </form>
                
                <!-- сообщение о сохранении настроек -->
                <div class="col-12 p-3 text-center unclickable zeroOpacity" v-bind:class="{ blinkAnim: saved }">
                    <h5>Изменения сохранены</h5>
                </div>

            </div>

            </div>
    
        </div>
  
    </div>
</template>
<script>
export default {
    created(){
          this.$parent.currentTab = "about";
    },

    //данные
    data: function(){
        return {
            errors: {},
            saved: false,
        }  
    },

}
</script>