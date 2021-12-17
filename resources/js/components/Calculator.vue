//Calculator
//страница калькулятора цена
<template>
    <div class="row h-100 justify-content-center fadeInAnim">
        <div class="col-12 col-md-10 mt-5">
            <div class="row justify-content-center mt-5">
                <div class="col-11 col-md-8">
                    <div class="row justify-content-center">
                            <div class="col-12 mt-5">
                                <h3 class="text-center">Я хочу...</h3>
                            </div>
                            <div class="col-12 text-center col-md-4 mt-3 calculatorCard personal" 
                                v-bind:class="{'selected': selectedProduct === 'businessCard'}" @click="selectProduct('businessCard')">
                                <h4 class="text-center">Сайт-визитку</h4>
                            </div>
                            <div class="col-12 col-md-4 text-center mt-3 calculatorCard landing"
                                v-bind:class="{'selected': selectedProduct === 'landing'}" @click="selectProduct('landing')">
                                <h4 class="text-center">Лендинг</h4>
                            </div>
                            <div class="col-12 col-md-4 text-center mt-3 calculatorCard telegram"
                                v-bind:class="{'selected': selectedProduct === 'telegram'}" @click="selectProduct('telegram')">
                                <h4 class="text-center">Telegram-бот</h4>
                            </div>
                            <div class="col-12 col-md-4 text-center mt-3 calculatorCard special"
                                v-bind:class="{'selected': selectedProduct === 'special'}" @click="selectProduct('special')">
                                <h4 class="text-center">Что-то особенное</h4>
                            </div>
                    </div>
                </div>
              
            </div>
            <div class="row justify-content-center mt-5 calculatorPrices" v-if="selectedProduct !== null">
                <div class="col-8 text-center">
                    <div class="fs-2 mb-3">
                        <h3><i :class="'bi' + ' ' + productIcon[selectedProduct]"></i> {{productTitle[selectedProduct]}}</h3>
                    </div>
                    <div class="fs-2 mb-3 col-12">
                       <p>{{productDescription[selectedProduct]}}</p>
                    </div>
                    <div class="fs-2 mb-3 col-12">
                       <h4><b>Цена *</b></h4>
                       <h3>≈ {{productPriceRange[selectedProduct]}}</h3>
                       <h6 style="font-size: 0.7rem">* примерный средний ценник, <br> окончательная цена может варьироваться в зависимости от сложности проекта</h6>
                    </div>
                </div>
            
            </div>
       
    </div>
    </div>
</template>
<script>
export default {
    // данные
    data(){
        return{
            selectedProduct: null,
            currentTitle: null,
            lorem: `Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quis odio libero repellat. Eveniet obcaecati rerum laboriosam corporis blanditiis, consectetur eius quas illum voluptatibus enim sed autem, deserunt nobis pariatur. Deserunt.
                       Provident blanditiis culpa qui et quaerat quibusdam quasi, aut atque rerum cum, placeat ducimus ex enim delectus? Blanditiis beatae odit facilis modi unde est eum hic aliquam, officia tempora corrupti?
                       Nulla itaque cupiditate in illo magnam ipsam, debitis fugiat similique sunt neque molestias quidem assumenda qui dolorem perferendis modi doloribus adipisci quod deserunt omnis, sit saepe eveniet veniam? Eligendi, ducimus.`,
            
        }
    },

    computed: {
        
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
        
        }
}
</script>