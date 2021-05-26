//ListOfProjects
//список проектов
<template>
    <div class="row">
        <ProjectListItem v-for="project in projectsList" 
                        :key="project.slug" :slug="project.slug"
                        :title="project.title"/>
    </div>
</template>
<script>
export default {
    //данные
    props: {
        projectsList: { type: Array, default: undefined },
    },
}
</script>