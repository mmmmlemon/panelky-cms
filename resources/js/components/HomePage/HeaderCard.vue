//HeaderCard
//карточка с общей информацией о владельце сайта и его роде занятий
<template>
    <div class="row h-100 width90pc bigCard d-flex justify-content-center borderUnderline">
         
        <!-- для десктопа -->
        <div class="d-none d-md-block textVertical fadeInAnim">
            <!-- Ошибка -->
            <div class="col-12" v-if="info === false">
                <Error errorMessage="Не удалось загрузить информацию о владельце сайта"/>
            </div>

            <!-- имя автора -->
            <transition name="name">
                <h1 v-if="startTransition === true && info.name != undefined" class="text-center  textVertical font5rem">
                    <b>{{info['name']}}</b>
                </h1>
            </transition>

            <transition name="occupation">
                <hr v-if="startTransition === true && info.occupation != undefined">
            </transition>
        
            <!-- род занятий -->
            <transition name="occupation">
                <p v-if="startTransition === true && info.occupation != undefined" class="text-center textVertical font2-5rem">
                    {{info['occupation']}}
                </p>
            </transition>

            <transition name="occupation">
                <hr v-if="startTransition === true && info.occupation != undefined">
            </transition>

            <!-- о себе -->
            <transition name="aboutMe">
                <p v-if="startTransition === true && info.aboutMe != undefined" class="text-center font1-8rem">
                    {{info['aboutMe']}}
                </p>
         
            </transition>
            <!-- нижний текст -->
            <transition name="bottomText">
                <h6 v-if="startTransition === true && info.bottomText != undefined" class="text-center font1-8rem">
                    <b>{{info['bottomText']}}</b>
                </h6>
            </transition>
 
        </div>
        <!-- для мобилок -->
        <div class="d-block d-md-none div-12 textVertical fadeInAnim">

            <!-- имя автора -->
            <transition name="name">
                <h1 v-if="startTransition === true && info.name != undefined" class="text-center textVertical font2-5rem">
                    <b>{{info['name']}}</b>
                </h1>
            </transition>

            <transition name="occupation">
                <hr v-if="startTransition === true && info.occupation != undefined">
            </transition>

            <!-- род занятий -->
            <transition name="occupation">
                <p v-if="startTransition === true && info.occupation != undefined" class="text-center textVertical font1-8rem">
                    {{info['occupation']}}
                </p>
            </transition>

            <transition name="occupation">
                <hr v-if="startTransition === true && info.occupation != undefined">
            </transition>

            <!-- о себе -->
            <transition name="aboutMe">
                <p v-if="startTransition === true && info.aboutMe != undefined" class="text-center font1-2rem">
                    {{info['aboutMe']}}
                </p>
            </transition>

            <br>

            <transition name="bottomText">
            <!-- нижний текст -->
                <h6 v-if="startTransition === true && info.bottomText != undefined" class="text-center font1-2rem">
                    <b>{{info['bottomText']}}</b>
                </h6>
            </transition>
        </div>
    </div>
</template>

<script>
export default {

    //хуки
    mounted(){
        //если компонент на главной странице сайта
        //то включить анимацию
        if(this.$route.path != '/admin/siteOwner'){
            //$parent.$parent - App.vue
            this.$parent.$parent.startHeaderCardTransition = true;
        }
    },

    //данные
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

    computed: {
        //вкл. анимацию
        startTransition: function(){
            if(this.$route.path !== '/admin/siteOwner')
            { return this.$parent.$parent.startHeaderCardTransition;}
            else
            { return true; }
        }
    }
    
}
</script>