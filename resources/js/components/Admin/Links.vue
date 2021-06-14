//Links
//ссылки и контакты
<template>
     <div class="row mt-5 justify-content-center fadeInAnim">
        <div class="col-12 col-md-6 mb-5">
            <ul class="nav nav-fill">
                <!-- Ссылки -->
                <li class="nav-item mr-2" v-on:click="changeCurrentTab('editLinks')">
                    <router-link to="/admin/links" v-bind:class="{'btn-light': currentTab === 'editLinks', 
                                                'btn-outline-light': currentTab !== 'editLinks'}"
                                                class="btn btn-sm btn-block" aria-current="page"
                                                >
                        <i class="bi bi-link"></i>
                    Ссылки
                    </router-link>
                </li>
                <!-- Контакты -->
                <li class="nav-item mr-2" v-on:click="changeCurrentTab('editContacts')">
                    <router-link to="/admin/links/contacts" v-bind:class="{'btn-light': currentTab === 'editContacts', 
                                                'btn-outline-light': currentTab !== 'editContacts'}"
                                                class="btn btn-sm btn-block" 
                                                >
                       <i class="bi bi-envelope"></i>
                        Контакты
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
        this.$store.dispatch('setCurrentTab', 'links');
    },

    //данные
    data: () => {
        return {
            currentTab: 'editLinks',
        }
    },

    //методы
    methods: {
        //сменить вкладку
        changeCurrentTab: function(tab){
            this.currentTab = tab;
        },
    }
    
}
</script>