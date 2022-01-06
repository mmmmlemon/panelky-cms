// EmailModal
// модальное окно для отправки e-mail'а
<template>
    <div class="deleteModalBody fadeInAnim zIndex7">
        
        <div class="row justify-content-center">
             <div class="transparentCard emailModalCard" v-bind:class="{'h-100 scrollableEmailModal': isMobile === true}">
                 <!-- форма отправки сообщения -->
                <div class="card-body">
                    <form action="POST" @submit.prevent="sendMessage"  v-bind:class="{'unclickable zeroOpacity': messageSent === true}">
                        <h4 class="card-title">Отправить сообщение</h4>
                        <b class="emailModalCloseButton" @click="close()">X</b>
                        <hr>
                        <div class="mb-3" v-if="pickedProject != -1">
                            <h4>Тип проекта: {{pickedProject}}</h4>
                        </div>
                        <div class="mb-3">
                            <label for="sender_email" class="form-label">Ваш контактный E-Mail*</label>
                            <input type="email" class="form-control" id="sender_email" placeholder="myemail@mail.com" v-model="messageEmail" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ваше сообщение</label>
                            <vue-editor style="background-color: white; color: black;" v-model="messageText"/>
                        </div>
                        <h6 v-if="emails !== null" style="color: black;" class="unclickable">Контактный E-Mail:</h6>
                        <h6 v-for="(email, index) of emails" v-bind:key="index" style="color: black;" class="pointer">
                            {{email.contact_url}}
                        </h6>
                        <br>
                        <!-- кнопки -->
                        <div class="d-grid gap-2 d-md-block">
                            <!-- отмена -->
                            <button class="btn btn-secondary" @click="close()">
                                <span><i class="bi bi-x"></i></span>
                                <span>Отмена</span>
                            </button>
                            <!-- удаление -->
                            <button type="submit" class="btn btn-success" :disabled="messageSent === true">
                                <span><i class="bi bi-envelope"></i></span>
                                <span>Отправить</span>
                            </button>
                        </div>
                    </form>
                </div> 
                <div class="card-body fadeInAnim" style="position: absolute; top: 15%; width: 100%;" v-if="messageSent === true">
                    <div class="row justify-content-center text-center mt-5">
                        <div class="col-12 mt-5">
                            <h3 v-if="messageSentDone === false">Отправка сообщения...</h3>
                            <h3 v-else>Сообщение отправлено</h3>

                            <!-- <i v-if="messageSentDone === false" class="fas fa-spinner fa-pulse" style="font-size: 2rem;"></i> -->
                            <i v-if="messageSentDone === true" class="bi bi-envelope fadeInAnim" style="font-size: 3rem;"></i>
                        </div>
                        <div class="col-12">
                            <p>Я свяжусь с вами по указанному E-Mail'у как только смогу.</p>
                        </div>
                        <div class="col-12">
                            <button @click="close()" type="button" class="btn btn-primary">Понятно</button>
                        </div>
                    </div>
       
                </div>


             </div>
        </div>

    

    </div>
</template>
<script>
export default {

    beforeCreate(){
          // получение почты
        axios.get('/api/getEmail').then(response => {
            this.emails = response.data.emails;
        })
    },

    data(){
        return{
            emails: null,
            messageEmail: null,
            messageText: null,
            messageSent: false,
            messageSentDone: false,

        }
    },

    computed: {
        pickedProject(){
            return this.$store.state.GlobalStates.pickedProject;
        },

        isMobile(){
            return this.$isMobileOnly;
        }
    },

    methods:{
        close(){
            this.$parent.showEmailModal = false;     
        },

        sendMessage(){

            this.messageSent = true;

            let formData = new FormData();

            if(this.pickedProject != -1){
                formData.append('pickedProject', this.pickedProject);
            }

            formData.append('messageEmail', this.messageEmail);
            formData.append('messageText', this.messageText);
            

            axios.post('/api/sendEmailMessage', formData).then(response => {
                this.messageSentDone = true;
                console.log(response.data);
            })

        }
        
    }
}
</script>