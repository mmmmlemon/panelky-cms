//Calculator
//страница калькулятора цена
<template>
    <div class="row h-100 justify-content-center fadeInAnim" v-if="orderTypesInfo !== -1">
        <div class="col-12 col-md-10 mt-2">
            <div class="row justify-content-center mt-2">
                <div class="col-11 col-md-8">
                    <div class="row justify-content-center">
                            <div class="col-12 mt-2">
                                <h3 class="text-center">Я хочу...</h3>
                            </div>

                            <div v-for="(orderType, index) of orderTypesInfo" v-bind:key="index" class="col-12 text-center col-md-4 mt-3 calculatorCard"
                                 v-bind:class="{'selected': selectedProduct === orderType.order_type}" @click="selectProduct(orderType.order_type)"
                                    :style="{backgroundColor: selectedProduct === orderType.order_type ? orderType.color_style : transparentWhiteColor}">
                                <h4 class="text-center">{{orderType.order_name}}</h4>
                            </div>

                            <!-- <div class="col-12 text-center col-md-4 mt-3 calculatorCard personal" 
                                v-bind:class="{'selected': selectedProduct === 'businessCard'}" @click="selectProduct('businessCard', 'v-a')">
                                <h4 class="text-center">Сайт-визитку</h4>
                            </div>
                            <div class="col-12 col-md-4 text-center mt-3 calculatorCard landing"
                                v-bind:class="{'selected': selectedProduct === 'landing'}" @click="selectProduct('landing', 'v-a')">
                                <h4 class="text-center">Лендинг</h4>
                            </div>
                            <div class="col-12 col-md-4 text-center mt-3 calculatorCard telegram"
                                v-bind:class="{'selected': selectedProduct === 'telegram'}" @click="selectProduct('telegram', 'v-b')">
                                <h4 class="text-center">Telegram-бот</h4>
                            </div>
                            <div class="col-12 col-md-4 text-center mt-3 calculatorCard special"
                                v-bind:class="{'selected': selectedProduct === 'special'}" @click="selectProduct('special', 'v-b')">
                                <h4 class="text-center">Что-то особенное</h4>
                            </div> -->
                    </div>
                </div>
              
            </div>
                <div v-for="(orderType) of orderTypesInfo" v-bind:key="orderType.order_type" class="row justify-content-center calculatorPrices">
                    <transition name="productDescription">
                        <div class="col-8 text-center mt-5" v-if="selectedProduct == orderType.order_type">
                            <div class="fs-2 mb-3">
                                <h3><i :class="orderType.order_bootstrap_icon"></i> {{orderType.order_name}}</h3>
                            </div>
                            <div class="fs-2 mb-3 col-12">
                                <p>{{orderType.order_desc}}</p>
                            </div>
                            <div class="fs-2 mb-3 col-12">
                                <h4><b>Цена *</b></h4>
                                <h2>{{orderType.price_range}}</h2>
                                <h4 class="mt-5"><b>Срок разработки *</b></h4>
                                <h2>{{orderType.time_range}}</h2>
                                <h6 style="font-size: 0.7rem">* примерный средний ценник и сроки разработки, <br>окончательная цена и срок разработки могут варьироваться в зависимости от сложности проекта</h6>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-8 text-center mt-4" v-if="selectedProduct == orderType.order_type">
                                <button type="button" class="btn btn-light btn-lg" @click="makeOrder()">
                                    <i class="bi bi-cart"></i> Заказать
                                </button>
                            </div>
                            </div>
                        </div>
               
                    </transition>

                </div>
    </div>
    </div>
</template>
<script>
export default {

    created(){
        this.$parent.currentTab = 'requestProject';
    },

    beforeMount(){
        if(this.order !== 1)
        { 
            axios.get('/api/getHomeSettings').then(response => {
                if(response.data.about !== 1){
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
            if(this.aboutSiteText === -1){
                this.$store.dispatch('getAboutSiteText');
            }   
        }   
    },

    // данные
    data(){
        return{
            transparentWhiteColor: 'rgba(255,255,255, 0.15)',
            selectedProduct: null,
            currentTitle: null,
            listOfProducts: ['businessCard', 'landing', 'telegram', 'special'],
            lorem: `Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quis odio libero repellat. Eveniet obcaecati rerum laboriosam corporis blanditiis, consectetur eius quas illum voluptatibus enim sed autem, deserunt nobis pariatur. Deserunt.
                       Provident blanditiis culpa qui et quaerat quibusdam quasi, aut atque rerum cum, placeat ducimus ex enim delectus? Blanditiis beatae odit facilis modi unde est eum hic aliquam, officia tempora corrupti?
                       Nulla itaque cupiditate in illo magnam ipsam, debitis fugiat similique sunt neque molestias quidem assumenda qui dolorem perferendis modi doloribus adipisci quod deserunt omnis, sit saepe eveniet veniam? Eligendi, ducimus.`,
            
        }
    },
    computed: {
        
        order(){
            return this.$parent.settings.order;
        },

        orderTypesInfo(){
            return this.$store.state.GlobalStates.orderTypesInfo;
        },

        productDescription(){
           return  {
                'businessCard': this.lorem,
                'landing': this.lorem,
                'telegram': this.lorem,
                'special': this.lorem
                
            };
        },

        productTitle(){
            return {
                'businessCard': 'Сайт-визитка',
                'landing': 'Лендинг',
                'telegram': 'Telegram-бот',
                'special': 'Что-то особенное'
            }
        },

        productIcon(){
            return {
                'businessCard': 'bi-card-heading',
                'landing': 'bi-list-nested',
                'telegram': 'bi-telegram',
                'special': 'bi-gift'
            }
        },

        productPriceRange(){
            return {
                'businessCard': 'от 30.000 до 45.000 ₽',
                'landing': 'от 40.000 до 70.000 ₽',
                'telegram': 'от 15.000 до 25.000 ₽',
                'special': 'от 15.000 до 100.000 ₽'
            }
        }
    },

    // методы
    methods: {
        selectProduct(productType){
            this.selectedProduct = productType;
        },

        makeOrder(productType){
            alert("мммммммм заказики..... 😳😳");
        }
        
        }
}
</script>