// OrderTypesSettings
// настройки вариантов заказов на проекты
<template>
    <div class="row mt-5 justify-content-center fadeInAnim">
        <div class="col-12 col-md-8 col-xl-6 mb-5">
            <ul class="nav nav-fill">
                <!-- Ссылки -->
                <li class="nav-item mr-2">
                    <router-link to="/admin/orderTypes" v-bind:class="{'btn-light': currentTab === 'orderTypes', 
                                                'btn-outline-light': currentTab !== 'orderTypes'}"
                                                class="btn btn-sm btn-block" aria-current="page"
                                                >
                        <i class="bi bi-list"></i>
                    Типы заказов
                    </router-link>
                </li>
                <!-- Контакты -->
                <li class="nav-item mr-2">
                    <router-link to="/admin/orderTypes/add" v-bind:class="{'btn-light': currentTab === 'addOrderType', 
                                                'btn-outline-light': currentTab !== 'addOrderType'}"
                                                class="btn btn-sm btn-block" 
                                                >
                       <i class="bi bi-file-earmark-plus"></i>
                        Добавить новый тип заказа
                    </router-link>
                </li>
            </ul>
        </div>
        <br>
        <!-- router-view для вкладок -->
        <div class="col-12">
            <router-view>
            </router-view>  
        </div>

    </div>
</template>
<script>
  export default{
      beforeMount(){
          this.$store.dispatch('setCurrentTab', 'orderTypes');
      },

      data(){
          return {
              currentTab: 'orderTypes',
          }
      }

  }

</script>