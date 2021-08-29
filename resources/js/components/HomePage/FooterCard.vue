//FooterCard
//футер с контактами и ссылками
<template>

    <div class="row h-75 w-75 bigCard d-flex justify-content-center goUpAnim" v-if="isVisible" id="links">
        <div class="col-12 col-md-5 textVertical">
            <!-- ссылки -->
            <div class="col-12 mt-5 fadeInAnim" v-bind:class="{'zeroOpacity':links == null && links == -1}">
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
            <!-- контактная кнопка -->
            <div class="col-12 text-center mt-5 fadeInAnim" id="contacts" @click="showContacts">
                <button type="button" class="btn btn-lg btn-outline-light">
                    <span>Контакты</span>
                </button>
                <br><br>
            </div>
            <div class="row justify-content-center text-center mt-2 mb-5" 
                        >
                <div v-for="(contact, index) in contacts" v-bind:key="index" class="col-6 col-md-3 m-0 p-0 mt-3 contactIcon"
                        :style="`transition: all 0.8s  ease-out; transition-delay: ${index/5}s; font-size: 2.5rem;`"
                        v-bind:class="{'zeroOpacity unclickable': contactsVisible === false}">
                    <a v-if="contact.contact_type === 'email'"  :href="'mailto:'+contact.contact_type">
                        <i class="goUpAnim fas fa-at" :style="`animation-duration: ${index/5}s;`"></i>
                    </a>
                    <a v-else :href="contact.contact_url" target="_blank">
                        <i :class="`goUpAnim fab fa-${contact.contact_type}`"></i>
                    </a>
                </div>
            </div>
                <!-- <a class="font18pt mb-5" :href="'mailto:'+email.email" v-bind:class="{'zeroOpacity unclickable': 
                    email.emailVisible === false, 'goUpAnim': email.emailVisible === true}">
                    <b>{{email.email}}</b>
                </a> -->
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
            if(this.contacts === -1)
            { this.$store.dispatch('getContacts'); }

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
            //видимость контактов
            contactsVisible: false,
        }
    },

    computed: {
        //список ссылок
        links: function(){
            return this.$store.state.GlobalStates.links;
        },
        //email
        contacts: {
            get(){
                return this.$store.state.GlobalStates.contacts;
            },
        },

        isVisible: {
            get(){  
                if(this.contacts !== -1 && this.links !== -1)
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

        //показать контакты
        showContacts(){
            this.contactsVisible = true;
        }

        //показать почту по нажатию кнопки
        // showEmail(){
        //     if(this.email.emailVisible !== true){
        //         this.email = this.reverseString(this.email.email);
        //     }
        // }
    }
}
</script>