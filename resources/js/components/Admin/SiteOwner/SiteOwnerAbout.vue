//SiteOwnerAbout.vue
//О сайте, настройки
<template>
    <div class="text-center fadeInAnim">
        <h1>SiteOwnerAbout.vue</h1>
    </div>
</template>
<script>
export default {
    created(){
          this.$parent.currentTab = "about";
    }
}
</script>