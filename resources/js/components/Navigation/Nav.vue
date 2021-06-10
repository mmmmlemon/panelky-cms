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
        <!-- О сайте -->
        <li class="nav-item">
            <router-link class="nav-link active" aria-current="page" to="/about">
                О сайте
            </router-link>
        </li>
    </ul>

</template>

<script>
export default {

}
</script>