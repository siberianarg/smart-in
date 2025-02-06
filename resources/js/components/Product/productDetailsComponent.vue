<template>
    <v-container>
        <!-- <h1>Товары</h1>
        <p>Список товаров будет загружаться из МС</p> -->

        <v-row justify="space-between" align="center">
            <h1>Список товаров</h1>
            <v-btn color="success" @click="openCreateDialog"
                >Добавить товар</v-btn
            >
        </v-row>

        <v-data-table
            :headers="headers"
            :items="products"
            :loading="loading"
            loading-text="Загрузка товаров..."
        >
            <template v-slot:item.actions="{ item }">
                <v-btn color="primary" @click="openEditDialog(item)"
                    >Редактировать</v-btn
                >
                <v-btn color="error" @click="deleteProduct(item.id)"
                    >Удалить</v-btn
                >
            </template>
        </v-data-table>

        <!-- Модальное окно для создания/редактирования товара -->
        <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-title>{{
                    isEditing ? "Редактировать товар" : "Создать товар"
                }}</v-card-title>
                <v-card-text>
                    <v-text-field
                        v-model="form.name"
                        label="Название товара"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="form.price"
                        label="Цена"
                        type="number"
                        required
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" @click="saveProduct"
                        >Сохранить</v-btn
                    >
                    <v-btn @click="closeDialog">Отмена</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>
<script>
export default {
    name: "productDetailsComponent",
    components: {},
    data() {
        return {};
    },
    mounted() {},
    methods: {},
    watch: {},
};
</script>

<style></style>
