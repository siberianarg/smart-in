<template>
    <div class="w-25">
        <div class="mb-3">
            <input
                type="text"
                class="form-control"
                v-model="name"
                id="name"
                placeholder="name"
            />
        </div>
        <div class="mb-3">
            <input
                type="number"
                class="form-control"
                v-model="age"
                id="age"
                placeholder="age"
            />
        </div>
        <div class="mb-3">
            <input
                type="text"
                class="form-control"
                v-model="job"
                id="job"
                placeholder="job"
            />
        </div>
        <div class="mb-3">
            <input
                @click.prevent="addPerson"
                class="btn btn-primary"
                value="Добавить"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "createComponent",
    data() {
        return {
            name: null,
            age: null,
            job: null,
        };
    },
    methods: {
        addPerson() {
            console.log("appPerson func: " + this.name, this.age, this.job);
            axios
                .post("/api/people", {
                    name: this.name,
                    age: this.age,
                    job: this.job,
                })
                .then((res) => {
                    this.name = null
                    this.age = null
                    this.job = null
                    console.log("Response:", res);
                })
                .catch((error) => {
                    console.error(
                        "Error:",
                        error.response ? error.response.data : error.message
                    );
                });
        },
    },
};
</script>

<style scoped></style>
