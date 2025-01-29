<template>
    <div>
        <createComponent> </createComponent>
        <indexComponent ref="index"></indexComponent>
    </div>
</template>

<script>
import axios from "axios";
import createComponent from "./createComponent.vue";
import indexComponent from "./indexComponent.vue";

export default {
    name: "postComponent",
    components: {
        createComponent,
        indexComponent,
    },
    data() {
        return {};
    },
    mounted() {},
    methods: {},
    computed: {},
    watch: {},
};
</script>

<style scoped></style>
