//FooterCard
//футер с контактами и ссылками
<template>

    <div class="row h-75 w-75 bigCard d-flex justify-content-center goUpAnim">
        <div class="div-12 textVertical">
            <!-- ссылки -->
            <div class="col-12" v-if="links !== false">
                <h1 class="text-center textVertical">
                    <p class="text-center textVertical font14pt">Ссылки</p>
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
            <div class="col-12 text-center mt-5" v-if="email !== null && email !== -1" id="contacts">
                <button type="button" class="btn btn-lg btn-outline-light" v-on:click="showEmail">
                    <span>Связаться со мной</span>
                    <span aria-hidden="true">
                        <i class="bi bi-at"></i>
                    </span>
                </button>
                <br><br>
                <a class="font18pt" :href="'mailto:'+email" v-bind:class="{'zeroOpacity unclickable': emailVisible === false, 'goUpAnim': emailVisible === true}">
                    <b>{{email}}</b>
                </a>
            </div> 
        </div>  
    </div>

</template>
<script>
export default {
    //хуки
    created(){
        this.$store.dispatch('getLinks');
        axios.get('/api/getEmail').then(response => {
            this.email = this.reverseString(response.data.email);
        }).catch(error => {
            this.email = false;
        })
    },

    //данные
    data: () => {
        return {
            //контактная почта
            email: -1,
            //видимость почты
            emailVisible: false,
        }
    },

    computed: {
        //список ссылок
        links: function(){
            return this.$store.state.AdminStates.links;
        }
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
            if(this.emailVisible !== true){
                this.email = this.reverseString(this.email);
                this.emailVisible = true;
            }
        }
    }
}
</script>