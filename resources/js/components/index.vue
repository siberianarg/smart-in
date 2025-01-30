<template>
    <div>
        <router-link :to="{ name: 'task.index' }"> Tasks </router-link>
        <router-link :to="{ name: 'task.create' }"> Create </router-link>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "index",
    components: {},
    data() {
        return {};
    },
    mounted() {},
    methods: {},
    watch: {},
};
</script>

<style></style>
