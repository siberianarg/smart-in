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
                        <td><a href="#" @click.prevent="changeEditPersonId(person.id)" class="btn btn-success">Edit</a></td>
                    </tr>
                    <tr class="d-none">
                        <th scope="row">{{ person.id }}</th>
                        <td><input type ="text" class="form-control"></td>
                        <td><input type ="number" class="form-control"></td>
                        <td><input type ="text" class="form-control"></td>
                        <td><a href="#" class="btn btn-success">Update</a></td>
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
            editPersonID: null,
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
        changeEditPersonId(id) {
            console.log(id);
            this.editPersonI = id
        }
    },
};
</script>

<style scoped></style>
