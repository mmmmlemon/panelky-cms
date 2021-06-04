//FooterCard
//футер с контактами и ссылками
<template>
    <div class="row h-75 w-75 bigCard d-flex justify-content-center goUpAnim">
        <div class="div-12 textVertical">
            <div class="col-12" v-if="links !== false">
                <h1 class="text-center textVertical">
                    <p class="text-center textVertical font14pt">{{footerTitle}}</p>
                    <hr class="mb-0">
                    <div class="row font21pt" v-if="links !== undefined && links !== -1">
                        <div v-for="link in links" :key="link.slug" class="col-12 col-md-12 mt-3">
                            <a :href="link.link_url" target="_blank">
                            <b>{{link.link_title}}</b>
                            </a>  
                        </div>
                    </div>
                </h1>
            </div>  
            <hr>
            <div class="col-12 text-center mt-5" v-if="email !== null && email !== -1">
                <button type="button" class="btn btn-lg btn-outline-light" v-on:click="showEmail">
                    <span>{{contactTitle}}</span>
                    <span aria-hidden="true">
                        <i class="bi bi-at"></i>
                    </span>
                </button>
                <br><br>
                <a class="font18pt" :href="'mailto:'+email" v-bind:class="{'zeroOpacity unclickable': emailVisible === false, 'goUpAnim': emailVisible === true}">
                    <b>{{email}}</b>
                </a>
            </div> 
        </div>
        
    </div>
</template>
<script>
export default {
    //хуки
    created(){
        this.$store.dispatch('getLinks');
        axios.get('/api/getEmail').then(response => {
            this.email = this.reverseString(response.data.email);
        }).catch(error => {
            this.email = false;
        })
    },

    //данные
    data: () => {
        return {
            email: -1,
            emailVisible: false,
        }
    },

    props: {
        footerTitle: { type: String, default: 'Ссылки' },
        contactTitle: { type: String, default: 'Связаться со мной' },
        contactEmail: { type: String, default: 'contact@mail.com' }
    },

    computed: {
        links: function(){
            return this.$store.state.AdminStates.links;
        }
    },

    //методы
    methods: {

        reverseString(str) {
            // Step 1. Use the split() method to return a new array
            var splitString = str.split(""); // var splitString = "hello".split("");
            // ["h", "e", "l", "l", "o"]
        
            // Step 2. Use the reverse() method to reverse the new created array
            var reverseArray = splitString.reverse(); // var reverseArray = ["h", "e", "l", "l", "o"].reverse();
            // ["o", "l", "l", "e", "h"]
        
            // Step 3. Use the join() method to join all elements of the array into a string
            var joinArray = reverseArray.join(""); // var joinArray = ["o", "l", "l", "e", "h"].join("");
            // "olleh"
            
            //Step 4. Return the reversed string
            return joinArray; // "olleh"
        },

        showEmail(){
            if(this.emailVisible !== true){
                this.email = this.reverseString(this.email);
                this.emailVisible = true;
            }
        }
    }
}
</script>