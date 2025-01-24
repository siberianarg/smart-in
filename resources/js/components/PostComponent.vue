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
                <tr v-for="person in persons">
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
                    age: 30,
                    job: "buzinessman",
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
            ],
        };
    },
    computed: {
        vasyaJob() {
            return this.firstName + " работает в булышной";
        },
    },
    mounted() {},
    methods: {},
    watch: {},
};
</script>

<style scoped></style>
