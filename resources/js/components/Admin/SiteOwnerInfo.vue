//AdminControlPanel
//контрольная панель администратора сайта
<template>
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-4">
                <h1>Forms</h1>
            </div>
            <div class="col-12 col-md-4 borderLeft d-flex justify-content-center">
                <HeaderCard :info="myInfo"/>
            </div>
        </div>


</template>
<script>
export default {
 
    computed: {
        myInfo: function(){
            return {
                'name': 'Ivan Dzhdishkovich',
                'occupation': 'A TikToker',
                'aboutMe': 'I do TikToks and dissapoint my parents',
                'footerText': 'BOTTOM TEXT',
            };
        }
    }


}
</script>