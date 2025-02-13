<template>
    <v-container>
        <v-btn
            class="mr-2"
            color="white"
            outlined
            :to="{ name: 'task.index' }"
            @click="reloadComponent"
            text="Задачи"/>
        <v-btn color="green" outlined :to="{ name: 'task.add' }">
            Создать задачу
        </v-btn>
        <router-view :key="componentKey"></router-view>
    </v-container>
</template>

<script>
export default {
    name: "taskDetailsComponent",
    data() {
        return {
            componentKey: 0, //динамический ключ
        };
    },
    methods: {
        reloadComponent() {
            this.componentKey += 1; //пересоздать <router-view>
        },
    },
};
</script>
