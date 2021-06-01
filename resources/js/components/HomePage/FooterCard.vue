//FooterCard
//футер с контактами и ссылками
<template>
    <div class="row h-75 w-75 bigCard d-flex justify-content-center">
        <div class="div-12 textVertical">
            <div class="col-12" v-if="links !== false">
                <h1 class="text-center textVertical">
                    <p class="text-center textVertical font14pt">{{footerTitle}}</p>
                    <hr>
                    <div class="row font21pt">
                        <div v-for="link in links" :key="link.slug" class="col-12 col-md-12 mt-3">
                            <a :href="link.link_url" target="_blank">
                            <b>{{link.link_title}}</b>
                            </a>  
                        </div>
                    </div>
                </h1>
            </div>  
            <hr v-if="links !== false">
            <br v-if="links !== false">
            <p class="text-center font18pt">
                <a :href="'mailto:'+contactEmail">
                    <button type="button" class="btn btn-lg btn-outline-light">
                        <span>{{contactTitle}}</span>
                        <span aria-hidden="true">
                            <i class="bi bi-at"></i>
                        </span>
                    </button>
                </a>
            </p>
        </div>
       
    </div>
</template>
<script>
export default {
    //хуки
    created(){
        this.$store.dispatch('getLinks');
    },

    //данные
    props: {
        footerTitle: { type: String, default: 'Ссылки' },
        contactTitle: { type: String, default: 'Связаться со мной' },
        contactEmail: { type: String, default: 'contact@mail.com' }
    },

    computed: {
        links: function(){
            return this.$store.state.AdminStates.links;
        }
    }
}
</script>