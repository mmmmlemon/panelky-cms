//Calculator
//страница калькулятора цена
<template>
    <div class="row h-100 justify-content-center fadeInAnim" v-if="orderTypesInfo !== -1 && order !== undefined">
        <SendEmailModal v-if="showEmailModal === true"/>
        <!-- если есть добавленные заказы -->
        <div class="col-12 col-md-10 mt-2" v-if="orderTypesInfo.length > 0">
            <div class="row justify-content-center mt-2">
                <div class="col-11 col-md-8">
                    <div class="row justify-content-center">
                        <div class="col-12 mt-2">
                            <h3 class="text-center">Мне нужен</h3>
                        </div>
                        <div v-for="(orderType, index) of orderTypesInfo" v-bind:key="index" class="col-12 text-center col-md-4 mt-3 calculatorCard"
                                v-bind:class="{'selected': selectedProduct === orderType.order_type}" @click="selectProduct(orderType.order_type)"
                                :style="{backgroundColor: selectedProduct === orderType.order_type ? orderType.color_style : transparentWhiteColor}">
                            <h4 class="text-center">{{orderType.order_name}}</h4>
                        </div>
                    </div>
                </div>  
            </div>
            <div v-for="(orderType) of orderTypesInfo" v-bind:key="orderType.order_type" class="row justify-content-center calculatorPrices">
                <transition name="productDescription">
                    <div class="col-12 col-md-8 text-center mt-5" v-if="selectedProduct == orderType.order_type">
                        <div class="fs-2 mb-3">
                            <h3><i :class="orderType.order_bootstrap_icon"></i> {{orderType.order_name}}</h3>
                        </div>
                        <div class="fs-2 mb-3 col-12">
                            <p>{{orderType.order_desc}}</p>
                        </div>
                        <hr>
                        <div class="fs-2 mb-3 col-12" v-if="orderType.add_info !== ''" v-html="orderType.add_info">
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-8 text-center mt-4 mb-4" v-if="selectedProduct == orderType.order_type">
                            <button type="button" class="btn btn-light btn-lg" @click="toggleEmailModal()">
                                <i class="bi bi-forward"></i> Отправить сообщение
                            </button>
                        </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
        <!-- если нет добавленных заказов -->
        <div class="row justify-content-center text-center goUpAnim mt-5" v-if="orderTypesInfo.length === 0">
            <div class="col-12">
                <h4>Хотите заказать разработку проекта?</h4>
                <h5>Напишите мне письмо на мою почту с деталями вашего проекта и я свяжусь с вами как только смогу.</h5>
                <h5>Спасибо!</h5>
                <h3 v-for="(email, index) of emails" v-bind:key="index" class="mt-5">
                    <b class="pointer">{{email.contact_url}}</b>
                </h3>
           
            </div>
        </div>
    </div>
</template>
<script>
import SendEmailModal from './Misc/SendEmailModal.vue'

export default {

    components: {
        SendEmailModal
    },

    created(){
        this.$parent.currentTab = 'requestProject';
    },

    beforeMount(){
    
        if(this.order !== 1)
        { 
            axios.get('/api/getHomeSettings').then(response => {
                if(response.data.order !== 1){
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
            // 
        }  

        // получение почты
        axios.get('/api/getEmail').then(response => {
            this.emails = response.data.emails;
        })
    },

    // данные
    data(){
        return{
            transparentWhiteColor: 'rgba(255,255,255, 0.15)',
            selectedProduct: null,
            currentTitle: null,
            emails: null,     
            showEmailModal: false,
        }
    },
    computed: {  
        order(){
            return this.$parent.settings.order;
        },

        orderTypesInfo(){
            return this.$store.state.GlobalStates.orderTypesInfo;
        },
    },

    // методы
    methods: {
        selectProduct(productType){
            this.selectedProduct = productType;
        },

        makeOrder(productType){
            alert("мммммммм заказики..... 😳😳");
        },

        toggleEmailModal(){
            this.showEmailModal = !this.showEmailModal;
            var projectTitle = this.orderTypesInfo.find(x => x.order_type === this.selectedProduct).order_name;
            this.$store.commit('setState', {state: 'pickedProject', value: projectTitle});
        }
        
    }
}
</script>