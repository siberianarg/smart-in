<template>
    <div>
        <v-table density="compact">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Job</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(person, index) in people" :key="person.id">
                    <!--для оптимизации рендеринга?-->
                    <td>{{ person.name }}</td>
                    <td>{{ person.age }}</td>
                    <td>{{ person.job }}</td>
                    <td>
                        <router-link
                            :to="{
                                name: 'person.edit',
                                params: { id: person.id },
                            }"
                        >
                            Edit
                        </router-link>
                    </td>
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
            axios
                .get("/api/people")
                .then((result) => {
                    this.people = result.data;
                })
                .catch();
        },
    },
    watch: {},
};
</script>

<style></style>
