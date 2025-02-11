<template>
    <v-container>
        <v-btn
            class="mr-2"
            color="white"
            outlined
            :to="{ name: 'task.index' }"
            text="Задачи"/>
        <v-btn color="green" outlined :to="{ name: 'task.add' }">
            Создать задачу
        </v-btn>
        <!-- для отображения дочерних компонентов -->
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
