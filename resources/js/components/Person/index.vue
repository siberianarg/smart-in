<template>
    <div>
        <v-table density="compact">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Job</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(person, index) in people" :key="person.id"> <!--для оптимизации рендеринга?-->
                    <td>{{ person.name }}</td>
                    <td>{{ person.age }}</td>
                    <td>{{ person.job }}</td>
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
            people: null,
        };
    },
    mounted() {
        this.getPeople();
    },
    methods: {
        getPeople() {
            axios.get("/api/people")
            .then((response) => {
                this.people = response.data;
            })
            .catch();
        },
    },
    watch: {},
};
</script>

<style></style>
