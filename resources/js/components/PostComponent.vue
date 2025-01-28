<template>
    <div>
        <createComponent> </createComponent>
        <indexComponent></indexComponent>
        <!-- <table class="table">
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
                    <td>{{ person.name }}</td>
                    <td>{{ person.age }}</td>
                    <td>{{ person.job }}</td>
                </tr>
            </tbody>
        </table> -->
    </div>
</template>

<script>
import axios from "axios";
import createComponent from "./createComponent.vue";
import indexComponent from "./indexComponent.vue";

export default {
    name: "postComponent",
    components: {
        createComponent,
        indexComponent,
    },
    data() {
        return {
            persons: null
        };
    },

    mounted() {
        // this.getPersons()
    },

    methods: {
        // getPersons() {
        //     axios.get('/persons')
        //     .then( res =>  // data from backend
        //     {
        //         this.persons = res.data
        //     })
        //     .catch( error => {

        //     })
        //     .finally({
                
        //     })
        // }
    },
    computed: {},
    watch: {},
};
</script>

<style scoped></style>
