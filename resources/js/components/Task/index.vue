<template>
    <div v-if="is_end">
        <v-table density="compact">
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
                    <v-btn
                        :to="{ name: 'task.show', params: { id: task.id } }"
                        variant="plain"
                        color="black"
                    >
                        {{ task.description }}
                    </v-btn>
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
                            color="blue"
                            outlined
                            :to="{
                                name: 'task.edit',
                                params: { id: task.id },
                            }"
                        >
                            Изменить
                        </v-btn>
                        <v-btn
                            color="red"
                            outlined
                            @click="deleteTask(task.id)"
                        >
                            Удалить
                        </v-btn>
                    </td>
                </tr>
            </tbody>
        </v-table>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "index",
    components: {},
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
            axios
                .get("/api/tasks")
                .then((result) => {
                    this.tasks = result.data.data
                    // console.log(result.data.data)
                })
                .catch();
        },
        deleteTask(id) {
            axios.delete(`/api/tasks/${id}`).then(() => {
                this.getTasks();
            });
        },
        getStatus(isCompleted) {
            if (isCompleted === 1) return "Завершен"
            if (isCompleted === 0) return "Не завершен"
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
            return new Date(date).toLocaleString("ru-RU", options)
        },
    },
    watch: {},
};
</script>

<style></style>
