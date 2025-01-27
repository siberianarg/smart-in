<template>
    <div>Third</div>
    <v-btn text="button" @click="sayHi" />

    <v-btn icon="$vuetify" text="Salam" @click="saySalam"/>
</template>

<script>
export default {
    name: "thirdComponent",
    components: {},
    data() {
        return {};
    },
    mounted() {},
    methods: {
        sayHi() {
            console.log("Hi");
        },
        saySalam() {
            console.log("SALAM")
        }
    },
    watch: {},
};
</script>

<style></style>
