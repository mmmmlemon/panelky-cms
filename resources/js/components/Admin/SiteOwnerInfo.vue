//AdminControlPanel
//контрольная панель администратора сайта
<template>
        <div class="row justify-content-center mt-5">
            <!-- форма редактирования -->
            <div class="col-12 col-md-4 mt-5">
                <form>
                    <div class="mb-3">
                        <h6>Имя владельца сайта</h6>
                        <input v-model="name" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <h6>Род занятий</h6>
                        <input v-model="occupation" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <h6>О себе</h6>
                        <textarea v-model="aboutMe" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <h6>Нижний текст</h6>
                        <input v-model="footerText" type="text" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-lg btn-block btn-outline-light">
                        Сохранить
                    </button>
                </form>
            </div>
            <!-- превью -->
            <div class="col-12 col-md-4 d-flex m-5 justify-content-center animatedBackground previewCard">
                <HeaderCard :info="{name: name, occupation: occupation, aboutMe: aboutMe, footerText: footerText}"/>
            </div>
        </div>


</template>
<script>
export default {

    data: function(){
        return {
            name: '',
            occupation: '',
            aboutMe: '',
            footerText: '',
        }
        
    },

    created(){
        this.name = "Ivan Dzhishkovich";
        this.occupation = "A TikToker";
        this.aboutMe = "I do TikToks and dissapoint my parents";
        this.footerText = "e"
    }
}
</script>