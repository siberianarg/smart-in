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
            <v-btn @click.prevent="updatePerson" color="blue" outlined>
                Update
            </v-btn>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "edit",
    components: {},
    data() {
        return {
            name: null,
            age: null,
            job: null,
        };
    },
    mounted() {
        this.getPerson();
    },
    methods: {
        getPerson() {
            axios
                .get(`/api/people/${this.$route.params.id}`)
                .then((result) => {
                    this.name = result.data.data.name;
                    this.age = result.data.data.age;
                    this.job = result.data.data.job;
                })
                .catch((error) => {
                    console.error("ошибка загрузки данных:", error);
                });
        },
        updatePerson() {
            axios
                .patch(`/api/people/${this.$route.params.id}`, {
                    name: this.name,
                    age: this.age,
                    job: this.job,
                })
                .then(() => {
                    // alert(`данные ${this.name} успешно обновлены`);
                    this.$router.push({
                        name: "person.show",
                        params: {
                            id: this.$route.params.id,
                        },
                    });
                })
                .catch((error) => {
                    console.error("Ошибка обновления:", error);
                });
        },
    },
};
</script>

<style></style>
