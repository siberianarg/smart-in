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
                        <td><a href="#" @click.prevent="changeEditPersonId(person.id, person.name, person.age, person.job)" class="btn btn-success">Edit</a></td>
                    </tr>
                    <tr v-if="editPersonId === person.id">
                        <th scope="row">{{ person.id }}</th>
                        <td><input type="text" class="form-control" v-model="person.name"></td>
                        <td><input type="number" class="form-control" v-model="person.age"></td>
                        <td><input type="text" class="form-control" v-model="person.job"></td>
                        <td><a href="#" @click.prevent="updatePerson(person.id)" class="btn btn-success">Update</a></td>
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
            this.editPersonId = id
            this.name = name
            this.age = age
            this.job = job
        }, 

        isEdit(id) {
            return this.editPersonId === id
        },

        updatePerson(id) {
            this.editPersonId = null;
            console.log(this.name, this.age, this.job)
            axios.patch(`/api/people/${id}`, {name: this.name, age: this.age, job: this.job})
            .then((res) => {
                console.log(res);
                
                // this.people = res.data;
            })
        },
    },
};
</script>

<style scoped></style>
