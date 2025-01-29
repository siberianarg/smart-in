<template>
    <div>
        <router-link :to="{ name: 'people.index' }"> People </router-link>
        <router-link :to="{ name: 'people.create' }"> Add </router-link>
        <router-view></router-view>
    </div>
</template>

<script>

export default {
    name: "index",
    components: {
    },
    data() {
        return {
        };
    },
    mounted() {},
    methods: {},
    watch: {},
};
</script>

<style></style>
