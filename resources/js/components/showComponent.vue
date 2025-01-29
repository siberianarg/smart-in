<template>
    <tr :class="this.$parent.isEdit(person.id) ? 'd-none' : ''">
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
</template>

<script>
export default {
    name: "showComponent",
    components: {},
    data() {
        return {};
    },
    props: ["person"],
    mounted() {},
    methods: {
        changeEditPersonId(id, name, age, job) {
            this.$parent.editPersonId = id;
            let editName = `edit_${id}`;
            let fullEditName = this.$parent.$refs[editName][0];

            fullEditName.name = name;
            fullEditName.age = age;
            fullEditName.job = job;
        },
        deletePerson(id) {
            axios.delete(`/api/people/${id}`).then((res) => {
                console.log(res);
                this.$parent.getPeople();
            });
        },
    },
};
</script>

<style scoped></style>
