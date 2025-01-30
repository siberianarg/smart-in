<template>
    <div>
        <v-btn color="blue" outlined :to="{ name: 'task.index' }"> Tasks </v-btn>
        <v-btn color="green" outlined :to="{ name: 'task.add' }"> Create </v-btn>
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
