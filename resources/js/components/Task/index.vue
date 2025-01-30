<template>
    <div>
        <v-table density="compact">
            <thead>
                <tr>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Data</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(task, index) in tasks" :key="task.id">
                    <!--для оптимизации рендеринга?-->
                    <td>
                        <router-link
                            :to="{
                                name: 'task.show',
                                params: { id: task.id },
                            }"
                            >{{ task.description }}
                        </router-link>
                    </td>
                    <td>{{ task.status }}</td>
                    <td>{{ task.data }}</td>
                    <td>
                        <router-link
                            :to="{
                                name: 'task.edit',
                                params: { id: task.id },
                            }"
                        >
                            Edit
                        </router-link>
                    </td>
                    <td>
                        <a
                            @click.prevent="deleteTask(task.id)"
                            href="#"
                            class="btn btn-outline-danger"
                            >Delete</a
                        >
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
            tasks: null,
        };
    },
    mounted() {
        this.getTasks();
    },
    methods: {
        getTasks() {
            axios
                .get("/api/tasks")
                .then((result) => {
                    this.tasks = result.data.data;
                })
                .catch();
        },
        deleteTask(id) {
            axios.delete(`/api/tasks/${id}`).then((result) => {
                this.getTasks();
                // router.push({ name: "task.index" });
            });
        },
    },
    watch: {},
};
</script>

<style></style>
