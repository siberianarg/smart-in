<template>
    <div>
        <thirdComponent> </thirdComponent>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Jobe</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="person in personAgeMoreThanTwenty">
                    <th scope="row">{{ person.id }}</th>
                    <td>{{ person.firstName }}</td>
                    <td>{{ person.age }}</td>
                    <td>{{ person.job }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import thirdComponent from "./thirdComponent.vue";
export default {
    name: "postComponent",
    components: {
        thirdComponent,
    },
    data() {
        return {
            persons: [
                {
                    id: 1,
                    firstName: "Beka",
                    age: 19,
                    job: "driver",
                },
                {
                    id: 2,
                    firstName: "Zhan",
                    age: 31,
                    job: "developer",
                },
                {
                    id: 3,
                    firstName: "Ilya",
                    age: 30,
                    job: "boss",
                },
                {
                    id: 4,
                    firstName: "Olga",
                    age: 20,
                    job: "manager",
                },
                {
                    id: 5,
                    firstName: "Saltanat",
                    age: 20,
                    job: "waiter",
                },
            ],
        };
    },
    computed: {
        //вычисляемые свойства
        personAgeMoreThanTwenty() {
            return this.persons.filter(function (person) {
                return person.age >= 20;
            });
        },
        personAgeLessThanTwenty() {
            return this.persons.filter(function (person) {
                return person.age < 20;
            });
        },
    },
    mounted() {},
    methods: {},
    watch: {},
};
</script>

<style scoped></style>
