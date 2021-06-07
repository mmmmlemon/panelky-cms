//Error
//компонент для вывода ошибок
<template>
    <div class="alert alert-danger text-center m-2 goUpAnim" role="alert">
        <h4><b>Ошибка</b></h4>
        {{errorMessage}}
    </div>
</template>

<script>
export default {
    props: {
        //текст ошибки
        errorMessage: { type: String, default: "Error message text" },
    }
}
</script>