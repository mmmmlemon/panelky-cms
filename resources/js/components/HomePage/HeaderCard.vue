// HeaderCard
// карточка с общей информацией о владельце сайта и его роде занятий
<template>
    <div class="h-75 w-85 bigCard d-flex justify-content-center row borderUnderline">
        <div class="div-12 textVertical">
            <!-- имя автора -->
            <h1 class="text-center textVertical goUpAnim">
                <b>{{myName}}</b>
            </h1>
            <hr class="goUpAnim">
            <!-- род занятий -->
            <p class="text-center textVertical font14pt fadeInAnim">
                {{myOccupation}}
            </p>
            <hr class="fadeInAnim">
            <!-- о себе -->
            <p class="text-center font14pt fadeInAnim">
                {{aboutMe}}
            </p>
            <br>
            <br>
            <!-- нижний текст -->
            <h6 class="text-center font14pt goUpAnim">
                <b>{{footerText}}</b>
            </h6>
        </div>
    </div>
</template>
<script>
export default {

    props: {
        myName: { type: String, default: 'Ivan Petrov' },
        myOccupation: { type: String, default: 'A programmer'},
        aboutMe: { type: String, default: 'I can do this and this and that and I can do it like that' },
        footerText: { type: String, default: 'Here are my projects' },
    },

}
</script>