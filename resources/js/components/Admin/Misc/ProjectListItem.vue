//ProjectListItem
//проект в списке проектов
<template>
    <div class="col-11 m-1 transparentCard active">
        <div class="row">
            <div class="col-10 text-center align-middle">
                <h2 class="" style="margin-top:10%;">{{title}}</h2>
            </div>      
            <div class="col-2">
                <div class="row">
                    <div class="col-12 m-1">
                        <button class="btn" style="color: white;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="col-12 m-1">
                        <button class="btn" style="color: white;">
                            <i class="bi bi-arrows-move"></i>
                        </button>
                    </div> 
                </div>
            </div>
        </div>    
    </div> 
</template>

<script>
export default {
    
    props: {
        title: { type: String, default: "Title"}
    }

}
</script>