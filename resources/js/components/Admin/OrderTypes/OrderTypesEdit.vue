// OrderTypesAdd
// форма добавления типов заказов
<template>
    <div class="row justify-content-center mt-5" v-if="orderType != null">
        <div class="col-12 col-md-3">
            <!-- основная форма -->
            <form @submit.prevent="submit" method="POST">
                <input type="text" class="invisible">
                <!-- Название проекта -->
                <div class="mb-3">
                    <h6>Наименование</h6>
                    <!-- наименовение -->
                    <input type="text" v-model="orderType.order_name" placeholder="Интернет-магазин, лендинг, сайт-визитка и т.п" class="form-control" required>
                    <div v-if="errors && errors.order_name" class="text-danger goUpAnim">{{ errors.order_name[0] }}</div>
                </div>
                <!-- Bootstrap-иконка -->
                <div class="mb-3">
                    <h6>Bootstrap-иконка (класс)</h6>
                    <input type="text" v-model="orderType.order_bootstrap_icon" placeholder="bi bi-email" class="form-control">
                    <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div>
                </div>
                <!-- Краткое описание заказа -->
                <div class="mb-3">
                    <h6>Краткое описание</h6>
                    <textarea type="text" rows="4" v-model="orderType.order_desc" placeholder="Краткое описание сути заказа" class="form-control"></textarea>
                    <div v-if="errors && errors.order_desc" class="text-danger goUpAnim">{{ errors.order_desc[0] }}</div>
                </div>
                <!-- Дополнительная информация -->
                <div class="mb-3">
                    <h6>Дополнительная информация</h6>
                    <vue-editor style="background-color: white; color: black;" v-model="orderType.add_info"/>
                    <div v-if="errors && errors.price_range" class="text-danger goUpAnim">{{ errors.add_info[0] }}</div>
                </div>
                <!-- Цвет подсветки -->
                <div class="mb-3">
                    <h6>Цвет карточки</h6>
                      <v-input-colorpicker  v-model="orderType.color_style" mode="hsla" swatches-max-height="200"/>
                    <div v-if="errors && errors.color_style" class="text-danger goUpAnim">{{ errors.color_style[0] }}</div>
                </div>
                <button class="btn btn-lg btn-block btn-outline-light" :disabled="saved === true">
                    Сохранить изменения
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
                <hr>
                <div class="fs-2 mb-3 col-12" v-html="orderType.add_info">      
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
            errors: null,
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
                formData.append('add_info', this.orderType.add_info);
                formData.append('color_style', this.orderType.color_style);
            }

            //отправка запроса
            axios.post('/admin/saveOrderType/', formData, {
                headers: {'Content-Type': 'multipart/form-data'} }).then(response => {
                    this.saved = true;

                    //редирект во вкладку "Управление проектами"
                    window.location.href="/admin/orderTypes";
                  
                }).catch(error => {
                  if(error.response.status === 422){ 
                  if(error.response.status === 422 || error.response.status === 500){ 
                        var errors = error.response.data;
                        this.errors = error.response.data.errors || {};
                     }
                }
            });

        }
    }
}
</script>