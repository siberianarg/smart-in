<template>
    <v-container>
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
