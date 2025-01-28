<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Job</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="person in people">
                    <tr>
                        <th scope="row">{{ person.id }}</th>
                        <td>{{ person.name }}</td>
                        <td>{{ person.age }}</td>
                        <td>{{ person.job }}</td>
                        <td>
                            <v-btn
                                color="success"
                                @click.prevent="
                                    changeEditPersonId(
                                        person.id,
                                        person.name,
                                        person.age,
                                        person.job
                                    )
                                "
                                outlined
                            >
                                Edit
                            </v-btn>
                        </td>
                    </tr>
                    <tr v-if="editPersonId === person.id">
                        <th scope="row">{{ person.id }}</th>
                        <td>
                            <v-text-field
                                type="text"
                                v-model="person.name"
                                label="name"
                                outlined
                                class="mb-3"
                            />
                        </td>
                        <td>
                            <v-text-field
                                type="number"
                                v-model="person.age"
                                label="age"
                                filled
                                class="mb-3"
                            />
                        </td>
                        <td>
                            <v-text-field
                                type="text"
                                v-model="person.job"
                                label="job"
                                outlined
                                class="mb-3"
                            />
                        </td>
                        <td>
                            <v-btn
                                color="success"
                                @click.prevent="updatePerson(person.id)"
                                outlined
                            >
                                Update
                            </v-btn>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "indexComponent",
    data() {
        return {
            people: null,
            editPersonId: null,
            name: null,
            age: null,
            job: null,
        };
    },
    mounted() {
        this.getPeople();
    },
    methods: {
        getPeople() {
            axios.get("/api/people").then((res) => {
                this.people = res.data;
            });
        },

        changeEditPersonId(id, name, age, job) {
            this.editPersonId = id;
            this.name = name;
            this.age = age;
            this.job = job;
        },

        isEdit(id) {
            return this.editPersonId === id;
        },

        updatePerson(id) {
            console.log("updatePerson: " + this.name, this.age, this.job);
            this.editPersonId = null;

            axios

                .patch(`/api/people/${id}`, {
                    name: this.name,
                    age: this.age,
                    job: this.job,
                })
                .then((res) => {
                    console.log(res);

                    // this.people = res.data;
                });
        },
    },
};
</script>

<style scoped></style>
