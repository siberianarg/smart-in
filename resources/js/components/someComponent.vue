<template>
    <div>1111</div>
</template>

<script>
export default {
    name: "someComponent",
    data() {
        return {};
    },
    mounted() {
       this.$parent.$parent.parentLog();
    },
    methods: {},
};
</script>

<style scoped></style>
