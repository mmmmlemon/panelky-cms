//ListOfProjects
//список проектов
<template>

<div class="row">

    <ProjectListItem v-for="project in projectsList" :key="project.id"
                        :title="project.title"/>

</div>

</template>
<script>
export default {
    
    props: {
        projectsList: { type: Array, default: undefined }
    }

}
</script>