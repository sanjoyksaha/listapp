<template>
    <div>
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
    </div>
</template>

<script>
export default {
    watch: {
            '$route':{
                handler: (to, from) => {
                    document.title = to.meta.title
                },
                immediate: true
            }
        },
}
</script>