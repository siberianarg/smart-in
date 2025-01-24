<template>
    <div>
        <thirdComponent> </thirdComponent>
        <div>Name: {{ firstName }}</div>
    </div>
</template>

<script>
import thirdComponent from "./thirdComponent.vue";
export default {
    name: "postComponent",
    components: {
        thirdComponent 
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