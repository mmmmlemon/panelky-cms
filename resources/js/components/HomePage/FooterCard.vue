<template>
    <div class="h-75 bigCard d-flex justify-content-center row" :style="{backgroundColor: randomColor}">
        <div class="div-12 textVertical">
            <h1 class="text-center textVertical">
                <p class="text-center textVertical font14pt">{{footerTitle}}</p>
                <hr>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <a href="https://github.com/mmmmlemon" target="_blank">
                            <img src="git.png" alt="GitHub/mmmmlemon">
                        </a>  
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="https://github.com/mmmmlemon" target="_blank">
                            <img src="kofi.png" width="64px" alt="">
                        </a>  
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="https://github.com/mmmmlemon" target="_blank">
                            <img src="insta.png" width="64px" alt="">
                        </a>  
                    </div>
                </div>
            </h1>
            <hr>
            <p class="text-center">{{contactTitle}}</p>
            <p class="text-center font18pt"><b><a :href="'mailto:'+contactEmail" target="_blank">{{contactEmail}}</a></b></p>
        </div>
       
    </div>
</template>
<script>
export default {

    props: {
        footerTitle: { type: String, default: 'Links' },
        contactTitle: { type: String, default: 'Contact me' },
        contactEmail: { type: String, default: 'contact@mail.com' }
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