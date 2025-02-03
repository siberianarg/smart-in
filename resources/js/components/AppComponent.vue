<template>
    <div>
        <v-btn color="blue" outlined class="mr-2" :to="{ name: 'task.index' }">
            Задачи
        </v-btn>
        <v-btn color="green" outlined :to="{ name: 'task.add' }">
            Создать задачу
        </v-btn>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "index",
    components: {},
    data() {
        return {}
    },
    mounted() {},
    methods: {},
    watch: {},
};
</script>

<style></style>
