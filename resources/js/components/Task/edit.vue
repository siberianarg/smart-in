<template>
    <div class="w-25">
        <div class="mb-1">
            <v-text-field
                type="text"
                v-model="description"
                label="description"
                outlined
            />
        </div>
        <div class="mb-1">
            <!-- <v-text-field type="number" v-model="is_completed" label="status" outlined /> -->
        </div>
        <div class="mb-1">
            <v-btn
                :disabled="!isDisabled"
                @click.prevent="updateTask"
                color="blue"
                outlined
            >
                Update
            </v-btn>
        </div>
    </div>
</template>

<script>
import axios from "axios"

export default {
    name: "edit",
    components: {},
    data() {
        return {
            description: null,
            is_completed: false
        };
    },
    mounted() {
        this.getTask()
    },
    methods: {
        getTask() {
            axios
                .get(`/api/tasks/${this.$route.params.id}`)
                .then((result) => {
                    this.description = result.data.data.description;
                    this.is_completed = result.data.data.status;
                })
                .catch((error) => {
                    console.error("ошибка загрузки данных:", error)
                });
        },
        updateTask() {
            axios
                .patch(`/api/tasks/${this.$route.params.id}`, {
                    description: this.description,
                    isCompleated: this.isCompleated,
                })
                .then(() => {
                    // alert(`данные ${this.description} успешно обновлены`);
                    this.$router.push({
                        name: "task.index",
                    });
                })
                .catch((error) => {
                    console.error("Ошибка обновления:", error)
                });
        },
    },
    computed: {
        isDisabled() {
            return this.description
        }
    }
}
</script>

<style></style>
