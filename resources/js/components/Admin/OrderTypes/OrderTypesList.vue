// OrderTypesList.vue

<template>
    <div class="row justify-content-center fadeInAnim" v-if="ordersList !== null">
        <div class="col-12 col-md-10 mb-2">
            <div class="row justify-content-center mt-3">
                <div v-for="(item, index) of ordersList" v-bind:key="index" 
                    class="col-11 col-md-3 text-center calculatorCard">
                    <h4>{{item.order_name}}</h4>
                    <h3><i :class="item.order_bootstrap_icon"></i></h3>
                    <hr>
                    <div class="row justify-content-center">
                        <!-- ред. -->
                        <router-link :to="'/admin/orderTypes/edit/'+item.order_type">
                            <button class="btn btn-light mr-3" title="Редактировать">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                        </router-link>
                        <!-- удалить -->
                        <button class="btn btn-light ml-3" title="Удалить">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    beforeMount(){
        this.$parent.currentTab = 'orderTypes';
    },

    mounted(){
        //получить список типов заказов
        axios.get('/api/getOrderTypesInfo').then(response => {
            this.ordersList = response.data;
        })
    },

    data() {
        return {
            ordersList: null,
        }
    }
}
</script>