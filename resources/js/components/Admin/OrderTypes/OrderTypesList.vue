// OrderTypesList.vue

<template>
    <div class="row justify-content-center fadeInAnim" v-if="ordersList !== -1">
        <div class="col-12 col-md-10 mb-2" v-if="ordersList.length > 0">
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
                        <button class="btn btn-light ml-3" title="Удалить" @click="deleteOrder(index)">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center text-center goUpAnim" v-if="ordersList.length === 0">
               <div class="col-12">
                    <h3>Нет типов заказов</h3>
                    <i class="bi bi-file-earmark-check font1-8rem"></i>
                    <hr>
                    <h5>Их можно добавить в разделе  <router-link to="/admin/orderTypes/add"><b>Добавить новый тип заказа</b></router-link></h5>
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
        this.$store.dispatch('getOrderTypesList');
    },


    computed:{
        ordersList(){
            return this.$store.state.AdminStates.ordersList;
        }
    },

    methods: {
        //удалить заказ
        deleteOrder(index){
            let order = this.ordersList[index];
            this.$store.dispatch('setDeleteModalInfo', {type: 'order', order_title: order.order_name, order_type: order.order_type});
        }
    }
}
</script>