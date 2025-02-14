<template>
    <v-container>
        <v-btn
            color="white"
            outlined
            class="mr-2"
            :to="{ name: 'product.index' }"
            text="Товары"
        />
        <!-- Используем route для перехода на страницу добавления товара -->
        <v-btn
            color="success"
            outlined
            :to="{ name: 'product.add' }"
            text="Добавить товар"
        />

        <!-- для отображения дочерних компонентов -->
        <router-view class="mt-4"></router-view>
    </v-container>
</template>

<script>
export default {
    name: "productDetailsComponent",
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
