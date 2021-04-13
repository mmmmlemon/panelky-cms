// HeaderCard
// карточка с общей информацией о владельце сайта и его роде занятий
<template>
    <div class="row h-100 width90pc bigCard d-flex justify-content-center borderUnderline">
        <!-- для десктопа -->
        <div class="d-none d-md-block textVertical fadeInAnim">

            <!-- имя автора -->
            <transition name="name">
                <h1 v-if="info.name != undefined" class="text-center textVertical font5rem">
                    <b>{{info['name']}}</b>
                </h1>
            </transition>

            <transition name="occupation">
                <hr v-if="info.occupation != undefined">
            </transition>
        
            <!-- род занятий -->
            <transition name="occupation">
                <p v-if="info.occupation != undefined" class="text-center textVertical font2-5rem">
                    {{info['occupation']}}
                </p>
            </transition>

            <transition name="occupation">
                <hr v-if="info.occupation != undefined">
            </transition>

            <!-- о себе -->
            <transition name="aboutMe">
                <p v-if="info.aboutMe != undefined" class="text-center font1-8rem">
                    {{info['aboutMe']}}
                </p>
         
            </transition>
            <!-- нижний текст -->
            <transition name="bottomText">
                <h6 v-if="info.bottomText != undefined" class="text-center font1-8rem">
                    <b>{{info['bottomText']}}</b>
                </h6>
            </transition>
 
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