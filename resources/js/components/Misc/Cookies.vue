// Cookies
// окно предпупреждения о Cookies
<template>
    <div class="row justify-content-left">
        <transition name="cookies">
            <div v-if="cookiesVisible === true && cookiesMessage !== null" class="d-none d-md-block pointerNone col-3 cookiesCard p-3 m-3 text-center">
                <h5>Этот сайт использует Cookies</h5>
                <hr class="m-1" style="background-color: black;">
                <div v-html="cookiesMessage"></div>
                <button class="btn btn-dark" @click="setCookiesAccepted">
                    <span>
                        OK
                    </span>
                    <span>
                        <i class="bi bi-check2"></i>
                    </span>
                </button>
            </div>
        </transition>
        <transition name="cookies">
            <div v-if="cookiesVisible === true && cookiesMessage !== null" class="d-block d-md-none pointerNone col-12 cookiesCard mobile p-3 text-center">
                <h5>Этот сайт использует Cookies</h5>
                <hr class="m-1" style="background-color: black;">
                <div v-html="cookiesMessage"></div>
                <button class="btn btn-dark" @click="setCookiesAccepted">
                    <span>
                        OK
                    </span>
                    <span>
                        <i class="bi bi-check2"></i>
                    </span>
                </button>
            </div>
        </transition>
    </div>


   
</template>
<script>
    export default {
        mounted(){
            this.cookiesVisible = true;
            
        },

        data: () => {
            return {
                cookiesVisible: false,
            }
        },

        props: {
            cookiesMessage: { default: null, type: String },
        },

        methods: {
           setCookiesAccepted(){
               //отправляем запрос на подтверждение кукисов
               this.cookiesVisible = false;

               axios.post('/api/setCookiesAccepted');
           }
        }
    }
</script>