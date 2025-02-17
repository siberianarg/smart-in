<template>
     <v-container>
        <!-- Кнопки действий (как кнопка Сохранить) -->
        <v-card class="pa-4 d-flex justify-space-between align-center">
            <v-btn
                color="white"
                outlined
                :to="{ name: 'task.index' }"
                class="text-black font-weight-bold"
                text="Задачи"/>
            <v-btn color="green" outlined :to="{ name: 'task.add' }">
                Создать задачу
            </v-btn>
        </v-card>

        <!-- Контент страниц -->
        <router-view></router-view>
    </v-container>
</template>

<script>
export default {
    name: "taskDetailsComponent",
    data() {
        return {
        };
    },
    methods: {
    },
};
</script>