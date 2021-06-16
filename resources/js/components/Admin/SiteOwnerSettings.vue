//SiteOwnerSettings
//настройки с информацией о владельце сайта
<template>
    <div class="row mt-5 justify-content-center fadeInAnim">
        <div class="col-12 col-md-9 mb-5">
            <ul class="nav nav-fill">
                <!-- Карточка приветствия -->
                <li class="nav-item mr-2">
                    <router-link to="/admin/siteOwner" class="btn btn-sm btn-block" aria-current="page"
                                    v-bind:class="{'btn-light': currentTab === 'headerCard', 
                                                    'btn-outline-light': currentTab !== 'headerCard'}">
                        <i class="bi bi-person-circle"></i>
                        Карточка приветствия
                    </router-link>
                </li>
                <!-- О сайте -->
                <li class="nav-item mr-2">
                    <router-link to="/admin/siteOwner/about" class="btn btn-sm btn-block"
                                    v-bind:class="{'btn-light': currentTab === 'about', 
                                                    'btn-outline-light': currentTab !== 'about'}">
                       <i class="bi bi-info-circle"></i>
                        О сайте
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
        this.$store.dispatch('setCurrentTab', 'siteOwner');
    },

    //данные
    data: () => {
        return {
            currentTab: 'headerCard',
        }
    }
    
}
</script>