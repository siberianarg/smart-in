<template>
    <div class="w-25">
        <div class="mb-1">
            <v-text-field type="text" v-model="description" label="description" outlined />
        </div>
        <div class="mb-1">
            <v-text-field type="number" v-model="status" label="status" outlined />
        </div>
        <div class="mb-1">
            <v-btn :disabled="!isDisabled" @click.prevent="store" color="blue" outlined> Create </v-btn>
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
            status: null,
        };
    },
    mounted() {},
    methods: {
        store() {
            axios
                .post("/api/tasks", {
                    description: this.description,
                    status: this.status,
                })
                .then(() => {
                    this.$router.push({ name: "task.index" }) //redirect
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
            return this.description && this.status
        }
    },
    watch: {},
    
};
</script>

<style scoped></style>
