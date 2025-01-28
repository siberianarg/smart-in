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
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="(person, index) in people">
                    <tr :class="isEdit(person.id) ? 'd-none' : ''">
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
                        <td>
                            <v-btn
                                color="danger"
                                @click.prevent="deletePerson(person.id)"
                                outlined
                            >
                                УДАЛИТЬ
                            </v-btn>
                        </td>
                    </tr>
                    <tr :class="isEdit(person.id) ? '' : 'd-none'">
                        <th scope="row">{{ person.id }}</th>
                        <td>
                            <v-text-field
                                type="text"
                                v-model="name"
                                label="name"
                                outlined
                                class="mb-3"
                            />
                        </td>
                        <td>
                            <v-text-field
                                type="number"
                                v-model="age"
                                label="age"
                                outlined
                                class="mb-3"
                            />
                        </td>
                        <td>
                            <v-text-field
                                type="text"
                                v-model="job"
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
        console.log(this.$parent.parentLog())
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
            this.editPersonId = null;

            axios
                .patch(`/api/people/${id}`, {
                    name: this.name,
                    age: this.age,
                    job: this.job,
                })
                .then((res) => {
                    console.log(res);
                    this.getPeople();
                });
        },

        deletePerson(id) {
            axios
                .delete(`/api/people/${id}`)
                .then((res) => {
                    console.log(res);
                    this.getPeople();
                });
        },

        indexLog() {
            console.log('this is indexComponent')
        },
    },
};
</script>

<style scoped></style>
