// Cookies
// окно предпупреждения о Cookies
<template>
    <div class="cookiesCard transparentCard p-3 m-3 text-center goUpCardAnim">
        <h4>Этот сайт использует <b>Cookies</b></h4>
        <i class="fas fa-cookie" style="font-size: 1.5rem;"></i>
        <hr>
        <p class="text-center">{{cookiesMessage}}</p>
        <button class="btn btn-sm btn-outline-light" @click="acceptCookies">Понятно</button>
    </div>
</template>
<script>
    export default {
        props: {
            cookiesMessage: { default: 'Default cookies message', type: String }
        },

        methods: {
            acceptCookies(){
                alert('Cookies accepted');
            }
        }
    }
</script>