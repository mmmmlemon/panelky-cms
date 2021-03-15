// AppAdmin
// корневой компонент для админки

<template>
    <div class="container col-12 vh-100">
        <h5>This is an AppAdmin <component :is="componentId"></component></h5>
        <router-view>
        </router-view>
    </div>
</template>
<script>
export default {
    
}
</script>