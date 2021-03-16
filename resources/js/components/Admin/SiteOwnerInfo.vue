//AdminControlPanel
//контрольная панель администратора сайта
<template>
        <div class="row justify-content-center">       
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
            <Preview :name="name" :occupation="occupation" :aboutMe="aboutMe" :footerText="footerText"/>

        </div>

</template>
<script>
export default {

    created(){
        this.name = "Egor Zhuravskiy";
        this.occupation = "PHP, JavaScript & Python developer";
        this.aboutMe = "High quality web projectlications for you and your family and your pet parrot 🦜 (squawk squawk)";
        this.footerText = "Here are some of my projects"
    },

    data: function(){
        return {
            name: '',
            occupation: '',
            aboutMe: '',
            footerText: '',
        }  
    },
}
</script>