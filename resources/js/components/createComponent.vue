<template>
    <div class="w-25">
        <div class="mb-1">
            <v-text-field type="text" v-model="name" label="name" outlined />
        </div>
        <div class="mb-1">
            <v-text-field type="number" v-model="age" label="age" outlined />
        </div>
        <div class="mb-1">
            <v-text-field type="job" v-model="job" label="job" outlined />
        </div>
        <div class="mb-3">
            <v-btn @click.prevent="addPerson" color="blue" outlined>
                Добавить
            </v-btn>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "createComponent",
    components: {
    },
    data() {
        return {
            name: null,
            age: null,
            job: null,
            obj: {
                color: "yellow",
                number: 11,
                isPublished: false
            }
        };
    },
    mounted() {},
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
                    this.name = null;
                    this.age = null;
                    this.job = null;
                    console.log("Response:", res);
                })
                .catch((error) => {
                    console.error(
                        "Error:",
                        error.response ? error.response.data : error.message
                    );
                });
            this.$parent.$refs.index.getPeople()
        },
    },
};
</script>

<style scoped></style>
