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
                    <editComponent :person="person" :ref="`edit_${person.id}`"></editComponent>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script>
import editComponent from "./editComponent.vue";
import axios from "axios";
export default {
    name: "indexComponent",
    components: {
        editComponent,
    },
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
            let editName = `edit_${id}`
            let fullEditName = this.$refs[editName][0]
            
            fullEditName.name = name;
            fullEditName.age = age;
            fullEditName.job = job;
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
            axios.delete(`/api/people/${id}`).then((res) => {
                console.log(res);
                this.getPeople();
            });
        },
    },
};
</script>

<style scoped></style>
