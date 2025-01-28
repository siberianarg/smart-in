<template>
    <div>Color: {{ color }}</div>
    <div>Number: {{ number }}</div>
    <div>is published: {{ isPublished }}</div>
</template>

<script>
export default {
    name: "someComponent",
    data() {
        return {};
    },
    props: ["color", "number", "isPublished"],
    mounted() {
        this.$parent.$parent.parentLog();
    },
    methods: {},
};
</script>

<style scoped></style>
