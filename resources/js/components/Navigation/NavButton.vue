// NavButton
// кнопка навигации

<template>
<div style="z-index: 2;">
    <button class="btn navButton" v-on:click="showNavMenu()">
        <i class="bi bi-three-dots-vertical" style="font-size: 1.5rem; color: white;"></i>
    </button>
    <div class="col-12 col-md-2 navMenu" :style="{right: navMenuRight}">
        <div class="row justify-content-end">
            <button class="btn" v-on:click="closeNavMenu()">
                <i class="bi bi-x" style="font-size: 1.5rem;"></i>
            </button>
            <div class="col-12">
                <br>
                <h6 class="text-center"><b>Projects</b></h6>
                <hr class="blackHR">
            </div>
            <div class="col-12 text-center">
                <h6><a href="#spotifyi" class="blackA">SpotiFYI</a></h6>
                <br>
                <h6>Weird Web-Site of [Mr. o_O]</h6>
                <br>
                <h6>Panelky</h6>
                <hr class="blackHR">
                <h6>Links</h6>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    
    data: function() {
        return {
            navMenuRight: '-500px',
        }     
    },

    methods: {
        showNavMenu: function() {
            if(isMobile())
            {
                alert('poo')
            }
            this.navMenuRight = '0px';
        },

        closeNavMenu: function() {
            this.navMenuRight = '-500px';
        }
    }
}
</script>