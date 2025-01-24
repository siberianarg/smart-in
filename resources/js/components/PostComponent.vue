<template>
    <div>
        <ThirdComponent> </ThirdComponent>
        <div>Name: {{ firstName }}</div>
    </div>
</template>

<script>
import ThirdComponent from "./ThirdComponent.vue";
export default {
    name: "PostComponent",
    components: {
        ThirdComponent 
    },
    data() {
        return {
            firstName: "Beka",
            age: 20,
            bolean: false,
            arr: [[]],
            someObj: "Zhan"
        };
    },
    mounted() {},
    methods: {},
    watch: {},
};
</script>

<style scoped></style>