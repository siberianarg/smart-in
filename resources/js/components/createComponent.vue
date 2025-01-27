<template>
    <div class="w-25">
        <div class="mb-3">
            <input
                type="text"
                class="form-control"
                v-model="name"
                id="name"
                placeholder="Disabled input"
            />
        </div>
        <div class="mb-3">
            <input
                type="number"
                class="form-control"
                v-model="age"
                id="agle"
                placeholder="Disabled input"
            />
        </div>
        <div class="mb-3">
            <input
                type="text"
                class="form-control"
                v-model="job"
                id="job"
                placeholder="Disabled input"
            />
        </div>
        <div class="mb-3">
            <input 
            type="submit" 
            class="btn btn-primary" 
            @click="addPerson"
            value="Добавить" />
        </div>
    </div>
</template>

<script>
export default {
    name: "createComponent",
    data() {
        return {
            name: null,
            age: null,
            job: null,
        };
    },
    methods: {
        addPerson() {
            console.log(this.name, this.age, this.job);
        },
    },
};
</script>

<style scoped></style>
