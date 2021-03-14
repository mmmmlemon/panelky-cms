// Navigation
// навигация сайта

<template>
    <!-- навигация -->
    <ul class="nav justify-content-center mt-3 font18pt">
        <!-- Home -->
        <li class="nav-item">
            <router-link class="nav-link active" aria-current="page" to="/">Home</router-link>
        </li>
        <!-- About -->
        <li class="nav-item">
            <router-link class="nav-link active" aria-current="page" to="/about">About</router-link>
        </li>
    </ul>
</template>
<script>
export default {

}
</script>