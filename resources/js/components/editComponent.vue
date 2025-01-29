<template>
    <tr :class="this.$parent.isEdit(person.id) ? '' : 'd-none'">
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

<script>
import axios from "axios";
export default {
    name: "editComponent",
    data() {
        return {
            name: null,
            age: null,
            job: null,
        };
    },
    props: ["person"],
    mounted() {},
    methods: {
        updatePerson(id) {
            this.$parent.editPersonId = null;

            axios
                .patch(`/api/people/${id}`, {
                    name: this.name,
                    age: this.age,
                    job: this.job,
                })
                .then((res) => {
                    console.log(res);
                    this.$parent.getPeople();
                });
        },
    },
};
</script>

<style scoped></style>
