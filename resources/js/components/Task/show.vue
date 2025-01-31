@@ -1,46 +0,0 @@
<template>
    <div v-if="task">
        <!-- show при условии что person не null-->
        <div>Описание:{{ this.task.description }}</div>
        <div>
            <v-chip :color="this.task.is_completed ? 'green' : 'red'" dark>
                Статус: {{ getStatus(task.is_completed) }}
            </v-chip>
        </div>
        <v-btn
            color="blue"
            outlined
            :to="{
                name: 'task.edit',
                params: { id: this.task.id },
            }"
            text="редактировать"
        />
    </div>
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
                    console.error("ошибка загрузки данных:", error);
                });
        },
        getStatus(isCompleted) {
            if (isCompleted === 1) return "Done";
            if (isCompleted === 0) return "Not done";
            return "Unknown";
        },
    },
    watch: {},
};
</script>

<style></style>
