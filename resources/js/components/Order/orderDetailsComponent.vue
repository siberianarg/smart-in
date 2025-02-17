<template>
    <v-container>
        <v-btn
            color="white"
            outlined
            class="mr-2"
            :to="{ name: 'order.index' }"
            text="Заказы"
        />
        <!-- Используем route для перехода на страницу добавления товара -->
        <v-btn
            color="success"
            outlined
            :to="{ name: 'order.index' }"
            text="Добавить заказ"
        />

        <!-- для отображения дочерних компонентов -->
        <router-view class="mt-4"></router-view>
    </v-container>
</template>

<script>
export default {
    name: "orderDetailsComponent",
    components: {},
    data() {
        return {
        };
    },
    mounted() {},
    methods: {
    },
    watch: {},
};
</script>

<style></style>
