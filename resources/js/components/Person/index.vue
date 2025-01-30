<template>
    <div>
        <v-table density="compact">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Job</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(person, index) in people" :key="person.id">
                    <!--для оптимизации рендеринга?-->
                    <td>
                        <router-link
                            :to="{
                                name: 'person.show',
                                params: { id: person.id },
                            }"
                            >{{ person.name }}
                        </router-link>
                    </td>
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
                    <td>
                        <a
                            @click.prevent="deletePerson(person.id)"
                            href="#"
                            class="btn btn-outline-danger"
                            >Delete</a
                        >
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
        deletePerson(id) {
            axios.delete(`/api/people/${id}`).then((result) => {
                this.getPeople();
                // router.push({ name: "person.index" });
            });
        },
    },
    watch: {},
};
</script>

<style></style>
