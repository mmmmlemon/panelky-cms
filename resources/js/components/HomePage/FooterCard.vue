//FooterCard
// футер с контактами и ссылками
<template>
    <div class="row h-75 w-75 bigCard d-flex justify-content-center">
        <div class="div-12 textVertical">
            <h1 class="text-center textVertical">
                <p class="text-center textVertical font14pt">{{footerTitle}}</p>
                <hr>
                <div class="row font21pt">
                    <div class="col-12 col-md-12 mt-3">
                        <a href="https://github.com/mmmmlemon" target="_blank">
                           <b>GitHub</b>
                        </a>  
                    </div>
                    <div class="col-12 col-md-12 mt-3">
                        <a href="https://github.com/mmmmlemon" target="_blank">
                            <b>Telegram</b>
                        </a>  
                    </div>
                    <div class="col-12 col-md-12 mt-3">
                        <a href="https://github.com/mmmmlemon" target="_blank">
                            <b>TikTok</b>
                        </a>  
                    </div>
                </div>
            </h1>
            <hr>
            <br>
            <p class="text-center font18pt">
                <a :href="'mailto:'+contactEmail">
                    <button type="button" class="btn btn-lg btn-outline-light">
                        <span>{{contactTitle}}</span>
                        <span aria-hidden="true">
                            <i class="bi bi-at"></i>
                        </span>
                    </button>
                </a>
                <p class="text-center">
                    <b>{{contactEmail}}</b>
                </p>
                <!-- <b><a :href="'mailto:'+contactEmail" target="_blank">{{contactEmail}}</a></b> -->
            </p>
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
}
</script>