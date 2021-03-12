// HeaderCard
// карточка с общей информацией о владельце сайта и его роде занятий
<template>
    <div class="h-100 w-90 bigCard d-flex justify-content-center row borderUnderline">
        <!-- для десктопа -->
        <div class="d-none d-md-block div-12 textVertical">
            <!-- имя автора -->
            <h1 class="text-center textVertical goUpAnim font5rem">
                <b>{{myName}}</b>
            </h1>
            <hr class="goUpAnim">
            <!-- род занятий -->
            <p class="text-center textVertical fadeInAnim font2-5rem">
                {{myOccupation}}
            </p>
            <hr class="fadeInAnim">
            <!-- о себе -->
            <p class="text-center fadeInAnim font1-8rem">
                {{aboutMe}}
            </p>
            <br>
            <br>
            <!-- нижний текст -->
            <h6 class="text-center goUpAnim font1-8rem">
                <b>{{footerText}}</b>
            </h6>
        </div>
        <!-- для мобилок -->
        <div class="d-block d-md-none div-12 textVertical">
            <!-- имя автора -->
            <h1 class="text-center textVertical goUpAnim font2-5rem">
                <b>{{myName}}</b>
            </h1>
            <hr class="goUpAnim">
            <!-- род занятий -->
            <p class="text-center textVertical fadeInAnim font1-8rem">
                {{myOccupation}}
            </p>
            <hr class="fadeInAnim">
            <!-- о себе -->
            <p class="text-center fadeInAnim font1-2rem">
                {{aboutMe}}
            </p>
            <br>
            <br>
            <!-- нижний текст -->
            <h6 class="text-center goUpAnim font1-2rem">
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