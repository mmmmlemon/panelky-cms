
<template>
    <div>
        <div class="alert alert-danger text-center marginVerticalSmall goUpAnim" role="alert">
            <h4><b>Ошибка</b></h4>
            {{errorMessage}}
        </div>
    </div>
</template>
<script>
export default {
    props: {
        errorMessage: { type: String, default: "Error message text" },
    }
}
</script>