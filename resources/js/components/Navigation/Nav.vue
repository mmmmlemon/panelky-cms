//Nav
//основная навигация сайта
<template>

    <!-- навигация -->
    <ul class="nav justify-content-center mt-3 font18pt fadeInAnim">
        <!-- Главная -->
        <li class="nav-item">
            <router-link class="nav-link active" aria-current="page" to="/">
                Главная
            </router-link>
        </li>
        <!-- Заказать проект -->
        <li class="nav-item" v-if="order === 1">
            <router-link class="nav-link active" aria-current="page" to="/requestProject">
                Заказать проект
            </router-link>
        </li>
        <!-- О сайте -->
        <li class="nav-item" v-if="about === 1">
            <router-link class="nav-link active" aria-current="page" to="/about">
                О сайте
            </router-link>
        </li>
    </ul>

</template>

<script>
export default {
    computed: {
        about(){
            return this.$parent.settings.about;   
        },

        order(){
            return this.$parent.settings.order;
        }
    }
}
</script>