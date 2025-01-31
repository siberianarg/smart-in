<template>
    <div class="w-25">
        <div class="mb-1">
            <v-text-field
                class="mt-3"
                type="text"
                v-model="description"
                label="description"
                outlined
            />
        </div>
        <!-- <div class="mb-1">
            <v-text-field type="number" v-model="status" label="status" outlined />
        </div> -->
        <div class="mb-1">
            <v-btn
                :disabled="!isDisabled"
                @click.prevent="store"
                color="blue"
                outlined
                text="Создать"
                />
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "create",
    components: {},
    data() {
        return {
            description: null,
            is_completed: false,
        };
    },
    mounted() {},
    methods: {
        store() {
            axios
                .post("/api/tasks", {
                    description: this.description,
                })
                .then(() => {
                    this.$router.push({ name: "task.index" }); //redirect
                })
                .catch((error) => {
                    console.error(
                        "Error:",
                        error.response ? error.response.data : error.messstatus
                    );
                });
        },
    },
    computed: {
        isDisabled() {
            return this.description;
        },
    },
    watch: {},
};
</script>

<style scoped></style>
