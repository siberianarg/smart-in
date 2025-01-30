<template>
    <div v-if="person">
        <!-- show при условии что person не null-->
        <div>Name: {{ this.person.name }}</div>
        <div>Age: {{ this.person.age }}</div>
        <div>Job: {{ this.person.job }}</div>
        <router-link
            :to="{
                name: 'person.edit',
                params: { id: this.person.id },
            }"
        >
            Edit
        </router-link>
    </div>
</template>

<script>
export default {
    name: "show",
    components: {},
    data() {
        return {
            person: null,
        };
    },
    mounted() {
        this.getPerson();
    },
    methods: {
        getPerson() {
            axios
                .get(`/api/people/${this.$route.params.id}`)
                .then((result) => {
                    this.person = result.data.data;
                })
                .catch((error) => {
                    console.error("ошибка загрузки данных:", error);
                });
        },
    },
    watch: {},
};
</script>

<style></style>
