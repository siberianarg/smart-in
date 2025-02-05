@@ -1,46 +0,0 @@
<template>
    <v-container v-if="task">
        <v-card class="pa-4">
            <v-card-title>Описание</v-card-title>
            <v-card-text>
                {{ task.description }}
            </v-card-text>

            <v-card-actions>
                <v-chip :color="task.is_completed ? 'green' : 'red'" dark>
                    {{ getStatus(task.is_completed) }}
                </v-chip>

                <v-spacer></v-spacer>
                
                <v-btn
                    color="blue"
                    outlined
                    :to="{ name: 'task.edit', params: { id: task.id } }"
                    text="Редактировать"
                    />
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
export default {
    name: "show",
    components: {},
    data() {
        return {
            task: null,
        };
    },
    mounted() {
        this.getTask();
    },
    methods: {
        getTask() {
            axios
                .get(`/api/tasks/${this.$route.params.id}`)
                .then((result) => {
                    this.task = result.data.data;
                })
                .catch((error) => {
                    console.error("ошибка загрузки данных:", error)
                });
        },
        getStatus(isCompleted) {
            if (isCompleted === 1) return "Done"
            if (isCompleted === 0) return "Not done"
            return "Unknown";
        },
    },
    watch: {},
};
</script>

<style></style>
