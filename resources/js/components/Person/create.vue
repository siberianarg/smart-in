<template>
    <div class="w-25">
        <div class="mb-1">
            <v-text-field type="text" v-model="name" label="name" outlined />
        </div>
        <div class="mb-1">
            <v-text-field type="number" v-model="age" label="age" outlined />
        </div>
        <div class="mb-1">
            <v-text-field type="text" v-model="job" label="job" outlined />
        </div>
        <div class="mb-1">
            <v-btn @click.prevent="store" color="blue" outlined> Add </v-btn>
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
            name: null,
            age: null,
            job: null,
        };
    },
    mounted() {},
    methods: {
        store() {
            axios
                .post("/api/people", {
                    name: this.name,
                    age: this.age,
                    job: this.job,
                })
                .then(() => {
                    this.$router.push({ name: "person.index" }) //redirect
                })
                .catch((error) => {
                    console.error(
                        "Error:",
                        error.response ? error.response.data : error.message
                    );
                });
        },
    },
    watch: {},
};
</script>

<style scoped></style>
