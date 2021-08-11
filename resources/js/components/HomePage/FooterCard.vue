//FooterCard
//футер с контактами и ссылками
<template>

    <div class="row h-75 w-75 bigCard d-flex justify-content-center goUpAnim" v-if="isVisible" id="links">
        <div class="div-12 textVertical">
            <!-- ссылки -->
            <div class="col-12 fadeInAnim" v-bind:class="{'zeroOpacity':links == null && links == -1}">
                <h1 class="text-center textVertical">
                    <p class="text-center textVertical font14pt pointerNone">Ссылки</p>
                    <hr class="mb-0">
                    <div class="row font21pt" v-if="links !== undefined && links !== -1">
                        <div v-for="link in links" :key="link.slug" class="col-12 col-md-12 mt-3">
                            <a :href="link.link_url" target="_blank">
                            <b>{{link.link_title}}</b>
                            </a>  
                        </div>
                    </div>
                </h1>
            </div>  
            <hr>
            <!-- контактная почта -->
            <div class="col-12 text-center mt-5 fadeInAnim" v-bind:class="{'zeroOpacity':email.email == null && email == -1}" id="contacts">
                <button type="button" class="btn btn-lg btn-outline-light" v-on:click="showEmail">
                    <span>Связаться со мной</span>
                    <span aria-hidden="true">
                        <i class="bi bi-at"></i>
                    </span>
                </button>
                <br><br>
                <a class="font18pt mb-5" :href="'mailto:'+email.email" v-bind:class="{'zeroOpacity unclickable': email.emailVisible === false, 'goUpAnim': email.emailVisible === true}">
                    <b>{{email.email}}</b>
                </a>
            </div> 
        </div>  
    </div>

</template>
<script>
export default {
    //хуки
    created(){
        
        if(this.links === -1)
        {
            this.$store.dispatch('getLinks');
            if(this.email === -1)
            { this.$store.dispatch('getEmail'); }

            this.isVisible = true;
        }
  
        // axios.get('/api/getEmail').then(response => {
        //     this.email = this.reverseString(response.data.email);
        //     this.isVisible = true;
        // }).catch(error => {
        //     this.email = false;
        // });

    },

    //данные
    data: () => {
        return {
            //видимость почты
            // emailVisible: false,
        }
    },

    computed: {
        //список ссылок
        links: function(){
            return this.$store.state.GlobalStates.links;
        },
        //email
        email: {
            get(){
                return this.$store.state.GlobalStates.email;
            },
            set: function(email){
                this.$store.commit('setState', {state: 'email', value: { email: email, emailVisible: true }});
            } 
        },

        isVisible: {
            get(){  
                if(this.email !== -1 && this.links !== -1)
                { return true; }
                else
                { return false; }
            },
            set(){
                //
            }
        },


    },

    //методы
    methods: {
        //сделать реверс строки
        //используется для того чтобы спам-боты не увидели почту в верстке
        reverseString(str) {
            var splitString = str.split(""); 
            var reverseArray = splitString.reverse(); 
            var joinArray = reverseArray.join(""); 
            return joinArray; 
        },

        //показать почту по нажатию кнопки
        showEmail(){
            if(this.email.emailVisible !== true){
                this.email = this.reverseString(this.email.email);
            }
        }
    }
}
</script>