// HeaderCard
// карточка с общей информацией о владельце сайта и его роде занятий
<template>
    <div class="row h-100 width90pc bigCard d-flex justify-content-center borderUnderline">
        <!-- для десктопа -->
        <div class="d-none d-md-block textVertical">
            <!-- имя автора -->
            <h1 class="text-center textVertical font5rem" v-bind:class="{ goUpAnim: info.name != undefined }">
                <b>{{info['name']}}</b>
            </h1>
            <hr class="goUpAnim">
            <!-- род занятий -->
            <p class="text-center textVertical font2-5rem" v-bind:class="{ fadeInAnim: info.occupation != undefined }">
                {{info['occupation']}}
            </p>
            <hr class="fadeInAnim">
            <!-- о себе -->
            <p class="text-center font1-8rem" v-bind:class="{ fadeInAnim: info.aboutMe != undefined }">
                {{info['aboutMe']}}
            </p>
            <br>
            <br>
            <!-- нижний текст -->
            <h6 class="text-center font1-8rem" v-bind:class="{ goUpAnim: info.bottomText != undefined }">
                <b>{{info['bottomText']}}</b>
            </h6>
        </div>
        <!-- для мобилок -->
        <div class="d-block d-md-none div-12 textVertical">
            <!-- имя автора -->
            <h1 class="text-center textVertical goUpAnim font2-5rem">
                <b>{{info['name']}}</b>
            </h1>
            <hr class="goUpAnim">
            <!-- род занятий -->
            <p class="text-center textVertical fadeInAnim font1-8rem">
                {{info['occupation']}}
            </p>
            <hr class="fadeInAnim">
            <!-- о себе -->
            <p class="text-center fadeInAnim font1-2rem">
               {{info['aboutMe']}}
            </p>
            <br>
            <br>
            <!-- нижний текст -->
            <h6 class="text-center goUpAnim font1-2rem">
                <b>{{info['footerText']}}</b>
            </h6>
        </div>
    </div>
</template>
<script>
export default {

    props: {
        info: { type: Object, default: function() {
            return {
                'name': undefined,
                'occupation': undefined,
                'aboutMe': undefined,
                'bottomText': undefined,
            }
        }},
    },

}
</script>