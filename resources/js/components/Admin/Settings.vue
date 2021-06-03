//Settings
//настройки сайта
<template>
    <div class="row mt-5 justify-content-center fadeInAnim">
        <div class="col-6 mb-5">
            <ul class="nav nav-fill">
                <!-- Ссылки -->
                <li class="nav-item mr-2">
                    <router-link to="/admin/settings" class="btn btn-sm btn-block" aria-current="page"
                                    v-bind:class="{'btn-light': currentTab === 'basicSettings', 
                                                    'btn-outline-light': currentTab !== 'basicSettings'}">
                        <i class="bi bi-gear"></i>
                        Общие
                    </router-link>
                </li>
                <!-- Главная -->
                <li class="nav-item mr-2">
                    <router-link to="/admin/settings/home" class="btn btn-sm btn-block"
                                    v-bind:class="{'btn-light': currentTab === 'homeSettings', 
                                                    'btn-outline-light': currentTab !== 'homeSettings'}">
                       <i class="bi bi-house"></i>
                        Главная
                    </router-link>
                </li>
                <!-- Дизайн -->
                <li class="nav-item mr-2">
                    <router-link to="/admin/settings/design" class="btn btn-sm btn-block"
                                    v-bind:class="{'btn-light': currentTab === 'designSettings', 
                                                    'btn-outline-light': currentTab !== 'designSettings'}">
                       <i class="bi bi-palette"></i>
                        Дизайн
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
export default {
    //хуки
    beforeMount(){
        this.$store.dispatch('setCurrentTab', 'settings');
    },

    //данные
    data: () => {
        return {
            currentTab: 'basicSettings',
        }
    }
    
}
</script>