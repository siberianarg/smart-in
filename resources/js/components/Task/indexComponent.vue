<template>
    <div v-if="is_end">
        <v-table class="mt-2">
            <thead>
                <tr>
                    <th class="text-grey-darken-1">Описание</th>
                    <th class="text-grey-darken-1">Статус</th>
                    <th class="text-grey-darken-1">Дата создания</th>
                    <th class="text-grey-darken-1">Действие</th>
                </tr>
            </thead>
            <tbody v-if="tasks.length > 0">
                <tr v-for="(task, index) in tasks" :key="task.id">
                    <v-list>
                        <v-list-item link>
                            <router-link
                                :to="{
                                    name: 'task.show',
                                    params: { id: task.id },
                                }"
                                class="text-decoration-none text-black font-weight-bold w-100 d-block"
                            >
                                <v-list-item-content>
                                    <v-list-item-title class="text-wrap">
                                        {{ task.description }}
                                    </v-list-item-title>
                                </v-list-item-content>
                            </router-link>
                        </v-list-item>
                    </v-list>
                    <td>
                        <v-chip
                            :color="task.is_completed ? 'green' : 'red'"
                            dark
                        >
                            {{ getStatus(task.is_completed) }}
                        </v-chip>
                    </td>
                    <td>
                        <v-tooltip text="Дата создания">
                            <template v-slot:activator="{ props }">
                                <span v-bind="props">{{
                                    formatDate(task.created_at)
                                }}</span>
                            </template>
                        </v-tooltip>
                    </td>
                    <td>
                        <v-btn
                            class="mr-2"
                            color="white"
                            outlined
                            :to="{ name: 'task.edit', params: { id: task.id } }"
                            text="Изменить"
                        />
                        <v-btn
                            color="red"
                            outlined
                            @click="deleteTask(task.id)"
                            text="Удалить"
                        />
                    </td>
                </tr>
            </tbody>
        </v-table>
    </div>
    <loadingComponent ref="loading" />
</template>

<script>
import axios from "axios";
import loadingComponent from "../loadingComponent.vue";

export default {
    name: "indexComponent",
    components: {
        loadingComponent,
    },
    data() {
        return {
            tasks: [],
            is_end: false,
        };
    },
    completed: {},
    mounted() {
        this.getTasks();
        this.is_end = true;
    },
    methods: {
        getTasks() {
            this.$refs.loading.dialog = true;
            axios
                .get("/api/tasks")
                .then((result) => {
                    this.tasks = result.data.data;
                })
                .catch()
                .finally(() => {
                    this.$refs.loading.dialog = false;
                });
        },
        deleteTask(id) {
            this.$refs.loading.dialog = true;
            axios
                .delete(`/api/tasks/${id}`)
                .then(() => {
                    this.getTasks();
                })
                .finally(() => {
                    this.$refs.loading.dialog = false;
                });
        },
        getStatus(isCompleted) {
            if (isCompleted === 1) return "Завершен";
            if (isCompleted === 0) return "Не завершен";
            return "Unknown";
        },
        formatDate(date) {
            const options = {
                year: "numeric",
                month: "numeric",
                day: "numeric",
                hour: "numeric",
                minute: "numeric",
            };
            return new Date(date).toLocaleString("ru-RU", options);
        },
    },
    watch: {},
};
</script>

<style></style>
