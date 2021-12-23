// OrderTypesAdd
// форма добавления типов заказов
<template>
    <div class="row justify-content-center" v-if="orderType != null">
        <div class="col-12 col-md-3">
            <!-- основная форма -->
            <form @submit.prevent="submit" method="POST">
                <input type="text" class="invisible">
                <!-- Название проекта -->
                <div class="mb-3">
                    <h6>Наименование</h6>
                    <!-- наименовение -->
                    <input type="text" v-model="orderType.order_name" placeholder="Интернет-магазин, лендинг, сайт-визитка и т.п" class="form-control" required>
                    <!-- <div v-if="errors && errors.order_name" class="text-danger goUpAnim">{{ errors.order_name[0] }}</div> -->
                </div>
                <!-- Bootstrap-иконка -->
                <div class="mb-3">
                    <h6>Bootstrap-иконка (класс)</h6>
                    <input type="text" v-model="orderType.order_bootstrap_icon" placeholder="bi bi-email" class="form-control">
                    <!-- <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div> -->
                </div>
                <!-- Краткое описание заказа -->
                <div class="mb-3">
                    <h6>Краткое описание</h6>
                    <textarea type="text" rows="4" v-model="orderType.order_desc" placeholder="Краткое описание сути заказа" class="form-control"></textarea>
                    <!-- <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div> -->
                </div>
                <!-- Ценник -->
                <div class="mb-3">
                    <h6>Ценник</h6>
                    <input type="text" v-model="orderType.price_range" placeholder="≈ от 1 до 100 ₽" class="form-control">
                    <!-- <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div> -->
                </div>
                <!-- Время -->
                <div class="mb-3">
                    <h6>Время разработки</h6>
                    <input type="text" v-model="orderType.time_range" placeholder="≈ от 1 до 100 дней" class="form-control">
                    <!-- <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div> -->
                </div>
                <!-- Цвет подсветки -->
                <div class="mb-3">
                    <h6>Цвет карточки</h6>
                      <v-input-colorpicker  v-model="orderType.color_style" mode="hsla" swatches-max-height="200"/>
                    <!-- <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div> -->
                </div>
                <button class="btn btn-lg btn-block btn-outline-light" :disabled="saved === true">
                    Добавить новый тип заказов
                </button>
            </form>
        </div>
        <div class="col-12 col-md-3">
             <h6>Превью</h6>
            <div class="row justify-content-center calculatorPrices text-center">
                <div class="fs-2 mb-3">
                    <h3 v-if="orderType.order_name != null && orderType.order_name != ''" class="fadeInAnim">
                        <i :class="orderType.order_bootstrap_icon"></i> 
                        {{orderType.order_name}}
                    </h3>
                </div>
                <div class="fs-2 mb-3 col-12">
                    <p v-if="orderType.order_desc != null && orderType.order_desc != ''" class="fadeInAnim">
                        {{orderType.order_desc}}
                    </p>
                </div>
                <div class="fs-2 mb-3 col-12">
                    <h4 v-if="orderType.price_range != null && orderType.price_range != ''" class="fadeInAnim">
                        <b>Цена *</b>
                    </h4>
                    <h2 v-if="orderType.price_range != null && orderType.price_range != ''" class="fadeInAnim">
                        {{orderType.price_range}}
                    </h2>
                    <h4 class="mt-5 fadeInAnim" v-if="orderType.time_range != null">
                        <b>Срок разработки *</b>
                    </h4>
                    <h2 v-if="orderType.time_range != null && orderType.time_range != ''" class="fadeInAnim">
                        {{orderType.time_range}}
                    </h2>
                    <h6 v-if="orderType.price_range != null && orderType.price_range != '' || orderType.time_range != null && orderType.time_range != ''" 
                            style="font-size: 0.7rem" class="fadeInAnim">
                            * примерный средний ценник и сроки разработки, <br>окончательная цена и срок разработки могут 
                            варьироваться в зависимости от сложности проекта
                    </h6>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    beforeMount(){
        this.$parent.currentTab = 'orderTypes';
        const slug = this.$route.params.slug;
        
        axios.get('/admin/getOrderType/'+slug).then(response =>{
            this.orderType = response.data;
        });
    },

    data(){
        return {
            orderType: null,
            saved: false,
        }
    },

    methods: {
        // отправить форму
        submit(){

            //добавление всех полей в js-форму
            let formData = new FormData();

            if(this.orderType !== null)
            {   
                formData.append('order_type', this.orderType.order_type);
                formData.append('order_name', this.orderType.order_name); 
                formData.append('order_desc', this.orderType.order_desc);
                formData.append('order_bootstrap_icon', this.orderType.order_bootstrap_icon);
                formData.append('price_range', this.orderType.price_range);
                formData.append('time_range', this.orderType.time_range);
                formData.append('color_style', this.orderType.color_style);
            }

            //отправка запроса
            axios.post('/admin/saveOrderType/'+ this.orderType.order_type, formData, {
                headers: {'Content-Type': 'multipart/form-data'} }).then(response => {
                    this.saved = true;

                    //редирект во вкладку "Управление проектами"
                    window.location.href="/admin/orderTypes";
                  
                }).catch(error => {
                    if(error.response.status === 422){
                        this.saved = false;
                        this.errors = error.response.data.errors || {};
                    }
            });

        }
    }
}
</script>