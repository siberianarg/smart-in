<template>
    <v-container>
        <v-row justify="space-between" align="center">
            <h1>Список товаров</h1>
            <!-- Используем route для перехода на страницу добавления товара -->
            <v-btn color="success" outlined :to="{ name: 'product.add' }"
                >Добавить товар</v-btn
            >
        </v-row>
        <router-view></router-view> 

        <v-data-table
            :headers="headers"
            :items="products"
            :loading="loading"
            loading-text="Загрузка товаров..."
        >
            <template v-slot:item.actions="{ item }">
                <!-- Переход к странице редактирования товара с передачей ID -->
                <v-btn
                    color="primary"
                    :to="{ name: 'product.edit', params: { id: item.id } }"
                >
                    Редактировать
                </v-btn>
                
                <v-btn color="error" @click="deleteProduct(item.id)"
                    >Удалить</v-btn
                >
            </template>
        </v-data-table>
        
    </v-container>
</template>

<script>
export default {
    name: "productDetailsComponent",
    data() {
        return {
            headers: [
                { text: "Название", value: "name" },
                { text: "Цена", value: "price" },
                { text: "Действия", value: "actions", sortable: false },
            ],
            products: [],
            loading: false,
        };
    },
    mounted() {
        this.fetchProducts();
    },
    methods: {
        fetchProducts() {
            axios
                .post("/api/products", {
                    description: this.description,
                })
                .then(() => {
                    // alert(`данные ${this.description} успешно добавлены`)
                    this.$router.push({ name: "product.index" });
                })
                .catch((error) => {
                    console.error(
                        "Error:",
                        error.response ? error.response.data : error.message
                    );
                });
        },
    },
    deleteProduct(id) {
        // Логика для удаления товара
        console.log(`Удаление товара с ID: ${id}`);
    },
};
</script>

<style scoped></style>
