<template>
    <div>Color: {{ obj.color }}</div>
    <div>Number: {{ obj.number > 10 ? "more 10" : "less 10" }}</div>
    <div>is published: {{ obj.isPublished ? "Published" : "Not published" }}</div>
</template>

<script>
export default {
    name: "someComponent",
    data() {
        return {};
    },
    props: {
        obj: {},
    },
    mounted() {},
    methods: {},
};
</script>

<style scoped></style>
