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
                    <div v-if="errors && errors.order_name" class="text-danger goUpAnim">{{ errors.order_name[0] }}</div>
                </div>
                <!-- Bootstrap-иконка -->
                <div class="mb-3">
                    <h6>Bootstrap-иконка (класс)</h6>
                    <input type="text" v-model="order_bootstrap_icon" placeholder="bi bi-email" class="form-control">
                    <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div>
                </div>
                <!-- Краткое описание заказа -->
                <div class="mb-3">
                    <h6>Краткое описание</h6>
                    <textarea type="text" rows="4" v-model="order_desc" placeholder="Краткое описание сути заказа" class="form-control"></textarea>
                    <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div>
                </div>
                <!-- Дополнительная информация -->
                <div class="mb-3">
                    <h6>Дополнительная информация</h6>
                    <vue-editor style="background-color: white; color: black;" v-model="add_info"/>
                    <div v-if="errors && errors.price_range" class="text-danger goUpAnim">{{ errors.add_info[0] }}</div>
                </div>
                <!-- Цвет подсветки -->
                <div class="mb-3">
                    <h6>Цвет карточки</h6>
                      <v-input-colorpicker  v-model="color_style" mode="hsla" swatches-max-height="200"/>
                    <div v-if="errors && errors.order_bootstrap_icon" class="text-danger goUpAnim">{{ errors.order_bootstrap_icon[0] }}</div>
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
                <hr>
                <div class="fs-2 mb-3 col-12" v-html="add_info">      
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
            add_info: null,
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
            if(this.add_info !== null)
            { formData.append('add_info', this.add_info); }
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