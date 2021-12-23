// OrderTypesAdd
// форма добавления типов заказов
<template>
    <div class="row justify-content-center">
        <div class="col-12 col-md-3">
            <!-- основная форма -->
            <form @submit.prevent="submit" method="POST">
                <input type="text" class="invisible">
                <!-- Название проекта -->
                <div class="mb-3">
                    <h6>Наименование</h6>
                    <!-- наименовение -->
                    <input type="text" v-model="order_name" placeholder="Интернет-магазин, лендинг, сайт-визитка и т.п" class="form-control" required>
                    <!-- <div v-if="errors && errors.order_name" class="text-danger goUpAnim">{{ errors.order_name[0] }}</div> -->
                </div>
                <!-- Bootstrap-иконка -->
                <div class="mb-3">
                    <h6>Bootstrap-иконка (класс)</h6>
                    <input type="text" v-model="order_bootstrap_icon" placeholder="bi bi-email" class="form-control">
                    <!-- <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div> -->
                </div>
                <!-- Краткое описание заказа -->
                <div class="mb-3">
                    <h6>Краткое описание</h6>
                    <textarea type="text" rows="4" v-model="order_desc" placeholder="Краткое описание сути заказа" class="form-control"></textarea>
                    <!-- <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div> -->
                </div>
                <!-- Ценник -->
                <div class="mb-3">
                    <h6>Ценник</h6>
                    <input type="text" v-model="price_range" placeholder="≈ от 1 до 100 ₽" class="form-control">
                    <!-- <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div> -->
                </div>
                <!-- Время -->
                <div class="mb-3">
                    <h6>Время разработки</h6>
                    <input type="text" v-model="time_range" placeholder="≈ от 1 до 100 дней" class="form-control">
                    <!-- <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div> -->
                </div>
                <!-- Цвет подсветки -->
                <div class="mb-3">
                    <h6>Цвет карточки</h6>
                      <v-input-colorpicker  v-model="color_style" mode="hsla" swatches-max-height="200"/>
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
                    <h3 v-if="order_name != null && order_name != ''" class="fadeInAnim">
                        <i :class="order_bootstrap_icon"></i> 
                        {{order_name}}
                    </h3>
                </div>
                <div class="fs-2 mb-3 col-12">
                    <p v-if="order_desc != null && order_desc != ''" class="fadeInAnim">{{order_desc}}</p>
                </div>
                <div class="fs-2 mb-3 col-12">
                    <h4 v-if="price_range != null && price_range != ''" class="fadeInAnim"><b>Цена *</b></h4>
                    <h2 v-if="price_range != null && price_range != ''" class="fadeInAnim">{{price_range}}</h2>
                    <h4 class="mt-5 fadeInAnim" v-if="time_range != null"><b>Срок разработки *</b></h4>
                    <h2 v-if="time_range != null && time_range != ''" class="fadeInAnim">{{time_range}}</h2>
                    <h6 v-if="price_range != null && price_range != '' || time_range != null && time_range != ''" 
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
        this.$parent.currentTab = 'addOrderType';
    },

    data(){
        return {
            order_name: null,
            order_bootstrap_icon: null,
            order_desc: null,
            price_range: null,
            time_range: null,
            color_style: '#878787',
            saved: false,
        }
    },

    methods: {
        // отправить форму
        submit(){

            //добавление всех полей в js-форму
            let formData = new FormData();

            if(this.order_name !== null)
            { formData.append('order_name', this.order_name); }
            if(this.order_desc !== null)
            { formData.append('order_desc', this.order_desc); }
            if(this.order_bootstrap_icon !== null)
            { formData.append('order_bootstrap_icon', this.order_bootstrap_icon); }
            if(this.price_range !== null)
            { formData.append('price_range', this.price_range); }
            if(this.time_range !== null)
            { formData.append('time_range', this.time_range); }
            if(this.color_style !== null)
            { formData.append('color_style', this.color_style); }

            //отправка запроса
            axios.post('/admin/addNewOrderType', formData, {
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