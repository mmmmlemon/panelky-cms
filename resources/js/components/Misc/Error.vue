<template>
    <div>
        <div class="alert alert-danger text-center marginVerticalSmall" role="alert">
            <h4>Ошибка</h4>
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