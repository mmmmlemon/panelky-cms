<template>
    <div class="h-75 bigCard d-flex justify-content-center row" :style="{backgroundColor: randomColor}">
        <div class="div-12 textVertical">
            <h1 class="text-center textVertical">
                <a :href="appUrl" target="_blank">
                    <b>{{appName}}</b>
                </a>
            </h1>
            <hr>
            <p class="text-center textVertical font14pt">{{appDescription}}</p>
            <hr>
            <p class="text-center">{{fullDescription}}</p>
            <br>
            <br>
            <p class="text-center"><b>{{footer}}</b></p>
        </div>
       
    </div>
</template>
<script>
export default {

    props: {
        appName: { type: String, default: 'App Name' },
        appUrl: { type: String },
        appDescription: { type: String, default: 'App description' },
        fullDescription: { type: String },
        footer: { type: String, default: 'Footer text' },
    },

    methods: {
        //сгенерировать случайный цвет для фона
        generateBackgroundColor: function(event){
            var randomColor = Math.floor(Math.random()*16777215).toString(16);

            console.log(randomColor)
            return "#"+randomColor;
        },
    },

    computed: {
        //случайный цвет для фона
        randomColor() {
            return this.generateBackgroundColor();
        }
    },


}
</script>