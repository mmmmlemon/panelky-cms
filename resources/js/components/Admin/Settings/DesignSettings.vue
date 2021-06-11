//DesignSettings
//настройки дизайна
<template>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="row justify-content-center">
                <div class="col-12">
                    <!-- форма -->
                    <form method="POST" @submit.prevent="submit">
                        <div class="row justify-content-center">
                            <!-- цвет фона 1 -->
                            <div class="col-2 mb-3 goUpAnim" v-if="bg_first_color !== -1">
                                <h6>Цвет фона №1</h6>
                                <v-input-colorpicker  v-model="bg_first_color"  @change="changeFirstColor"/>
                                <input type="text" class="form-control" placeholder="HEX" v-model="bg_first_color" v-on:keyup="changeFirstColorInput">
                            </div>
                            <!-- цвет фона 2 -->
                            <div class="col-2 mb-3 goUpAnim"  v-if="bg_second_color !== -1">
                                <h6>Цвет фона №2</h6>
                                <v-input-colorpicker  v-model="bg_second_color" @change="changeSecondColor"/>
                                <input type="text" class="form-control" placeholder="HEX" v-model="bg_second_color" v-on:keyup="changeSecondColorInput">
                            </div>
                        </div> 
                        <!-- превью -->
                        <div class="row justify-content-center goUpAnim" v-if="bg_first_color != -1 && bg_second_color != -1">
                            <div class="col-5 text-center" v-bind:style="previewStyle">
                                <br><br>
                                <h3>Превью</h3>
                                <br><br>
                            </div>
                        </div>
                        <!-- Сохранить -->
                        <div class="row justify-content-center goUpAnim m-5" v-if="bg_first_color != -1 && bg_second_color != -1">
                            <div class="col-5">
                                <button class="btn btn-outline-light btn-lg btn-block ml-2" title="Сохранить изменения">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- сообщение о сохранении настроек -->
        <div class="col-12 p-1 text-center unclickable zeroOpacity" v-bind:class="{ blinkAnim: saved }">
            <h5>Изменения сохранены</h5>
        </div>
    </div>
</template>
<script>
export default {
    //хуки
    created(){
        //получить настройки
        axios.get('/api/getBgColors').then(response => {
            this.bg_first_color = response.data.bg_first_color;
            this.bg_second_color = response.data.bg_second_color;
            this.previewStyle = {
                background: `linear-gradient(to right top, ${this.bg_first_color}, ${this.bg_second_color})`,
            };
        })
    },
    mounted(){
        this.$parent.currentTab = 'designSettings';
    },

    //данные
    data: () => {
        return {
            //первый цвет
            bg_first_color: -1,
            //второй цвет
            bg_second_color: -1,
            //стили для превью
            previewStyle: {},
            saved: false,
        }
    },

    //методы
    methods: {
        //изменение цветов
        changeFirstColorInput(result){
            this.previewStyle.background = `linear-gradient(to right top, ${result.path[0].value}, ${this.bg_second_color})`;
        },
        changeSecondColorInput(result){
            this.previewStyle.background = `linear-gradient(to right top, ${this.bg_first_color}, ${this.bg_second_color})`;
        },
        changeFirstColor(result){
            this.previewStyle.background = `linear-gradient(to right top, ${result}, ${this.bg_second_color})`;
        },
        changeSecondColor(result){
            this.previewStyle.background = `linear-gradient(to right top, ${this.bg_first_color}, ${result})`;   
        },

        //сохранить
        submit(){
            this.saved = false;
            let formData = new FormData();
            formData.append('bg_first_color', this.bg_first_color);
            formData.append('bg_second_color', this.bg_second_color);

            axios.post('/admin/saveBgColors', formData).then(response => {
                this.saved = true;
                this.$store.dispatch('getAnimatedBackground');
            }).catch(error => {
                    var errors = error.response.data;
                    this.$store.dispatch('setErrors', error.response.data.message);
            })
        }   
    }
}
</script>