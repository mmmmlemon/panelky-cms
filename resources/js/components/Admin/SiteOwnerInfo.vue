//AdminControlPanel
//контрольная панель администратора сайта
<template>
        <div class="row justify-content-center">       
            <!-- форма редактирования -->
            <div class="col-12 col-md-4 mt-5">
                <form @submit.prevent="submit" methods="POST">
                    <div class="mb-3">
                        <h6>Имя владельца сайта</h6>
                        <input v-model="name" type="text" class="form-control">
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>
                    <div class="mb-3">
                        <h6>Род занятий</h6>
                        <input v-model="occupation" type="text" class="form-control">
                        <div v-if="errors && errors.occupation" class="text-danger">{{ errors.occupation[0] }}</div>
                    </div>
                    <div class="mb-3">
                        <h6>О себе</h6>
                        <textarea v-model="aboutMe" class="form-control"></textarea>
                        <div v-if="errors && errors.aboutMe" class="text-danger">{{ errors.aboutMe[0] }}</div>
                    </div>
                    <div class="mb-3">
                        <h6>Нижний текст</h6>
                        <input v-model="footerText" type="text" class="form-control">
                        <div v-if="errors && errors.footerText" class="text-danger">{{ errors.footerText[0] }}</div>
                    </div>

                    <button class="btn btn-lg btn-block btn-outline-light">
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
            errors: {},
            fields: {},
            name: '',
            occupation: '',
            aboutMe: '',
            footerText: '',
        }  
    },

    methods: {
        submit() {
            this.errors = {};

            this.fields = {
                name: this.name,
                occupation: this.occupation,
                aboutMe: this.aboutMe,
                footerText: this.footerText,
            };

            console.log(this.fields);

            axios.post('/submitForm', this.fields).then(response => {
                alert('Message sent!');
            }).catch(error => {
                if(error.response.status === 422){
                    this.errors = error.response.data.errors || {};
                }
            });
        }
    }
}
</script>