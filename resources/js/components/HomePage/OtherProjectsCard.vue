//OtherProjectsCard
//список других проектов
<template>

    <div class="row bigCard d-flex justify-content-center borderUnderline" style="transition: all 1s;" id="other" 
            v-scroll="handleScroll" v-bind:class="{'zeroOpacity unclickable': visible == false}">
        <div class="d-block d-md-block col-12 textVertical fadeInAnim m-5 goUpCardAnim">
            <h3 class="text-center pointerNone mb-5">Другие проекты</h3>
            <!-- <h6  class="text-center pointerNone mb-5">разработанные мной или с моим участием</h6> -->
            <!-- список проектов -->
            <div class="row justify-content-center">
                <div v-for="(project, index) in projects" :key="project.slug" class="transparentCard m-1 otherProject" 
                    :style="`transition: all 0.8s  ease-out; transition-delay: ${index/5}s;`"
                    v-bind:class="{'zeroOpacity unclickable' : visible == false, 'invisible': isMobile === true && index > 4,
                    'col-3': screenOrientation === 'horizontal', 'col-12': screenOrientation === 'vertical'}">
                    <!-- если у прое,кта есть лого -->
                    <div class="card-body text-center" v-if="project.project_icon !== null">
                        <!-- заголовок -->
                        <h4 class="card-title text-center wordBreak">
                            <a :href="project.project_url" target="_blank">
                                <b>{{project.project_title}}</b>
                            </a>  
                        </h4>
                        <!-- лого -->
                        <img :src="project.project_icon" class="projectLogo" alt="">
                        <h6 class="mt-2">{{project.project_bottomText}}</h6>
                     </div>
                     <!-- если у пректа нет лого -->
                     <div v-else class="card-body text-center textVertical">
                        <h4 class="card-title text-center mt-3">
                            <a :href="project.project_url" target="_blank">
                                <b>{{project.project_title}}</b>
                            </a>
                            <h6 class="mt-2">{{project.project_bottomText}}</h6>
                        </h4>
                     </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    //данные
    props: {
        //список проектов
        projects: { type: Array, default: undefined },
    },

    //данные
    data: () => {
        return {
            //видимость карточки
            visible: false,
        }
    },


    computed: {
        //видимость карточки
        setVisible: {
           get() {
               this.visible = false;
           },
           set(value){
               this.visible = value;
           }
        },
        isMobile: function(){
            return this.$isMobile;
        },
        screenOrientation: function(){
             return this.$store.state.GlobalStates.screenOrientation;
        }
    },

    //методы
    methods: {
        //при скролле страницы показать карточку когда она будет 
        //в поле видимости
        handleScroll: function (evt, el){
            if (el.getBoundingClientRect().top < 400) {
                this.setVisible = true;
            }
            return el.getBoundingClientRect().top < 400;
        }
    }
}
</script>