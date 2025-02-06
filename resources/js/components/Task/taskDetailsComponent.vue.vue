<template>
    <v-container>
        <h1>Задачи</h1>
        <p>Страница для управления задачами</p>
        <v-btn
                color="blue"
                outlined
                class="mr-2"
                :to="{ name: 'task.index' }"
            >
                Задачи
            </v-btn>
            <v-btn color="green" outlined :to="{ name: 'task.add' }">
                Создать задачу
            </v-btn>
            <router-view></router-view>
    </v-container>
</template>

<script>
export default {
    name: "taskDetailsComponent",
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
