<template>
    <div v-if="is_end">
        <h1 class="mt-4">Список товаров</h1>
        <v-table class="mt-2">
            <thead>
                <tr>
                    <th class="text-grey-darken-1">#</th>
                    <th class="text-grey-darken-1">Код</th>
                    <th class="text-grey-darken-1">Название</th>
                    <th class="text-grey-darken-1">Стоимость</th>
                    <th class="text-grey-darken-1">Действие</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in products" :key="product.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ product.code }}</td>
                    <td>
                        <v-list-item
                            link
                            :to="{
                                name: 'product.show',
                                params: { id: product.id },
                            }"
                            variant="plain"
                            color="black"
                            class="text-decoration-none text-black font-weight-bold w-100 d-block"
                        >
                            {{ product.name }}
                        </v-list-item>
                    </td>
                    <td>
                        <v-chip
                            :color="
                                product.salePrices &&
                                product.salePrices[0]?.value > 0
                                    ? 'green'
                                    : 'red'
                            "
                            dark
                        >
                            {{
                                product.salePrices &&
                                product.salePrices[0]?.value > 0
                                    ? product.salePrices[0].value / 100 + " ₸"
                                    : "Нет цены"
                            }}
                        </v-chip>
                    </td>
                    <td>
                        <v-btn
                            outlined
                            :to="{
                                name: 'product.edit',
                                params: { id: product.id },
                            }"
                        >
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                    </td>
                    <td>
                        <v-btn
                            color="red"
                            outlined
                            @click="deleteOrder(order.id)"
                        >
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </td>
                </tr>
            </tbody>
        </v-table>
    </div>
    <loading-component ref="loading" />
</template>

<script>
import axios from "axios";
import loadingComponent from "../loadingComponent.vue"; // Импортируем компонент загрузки

export default {
    name: "indexProductComponent",
    components: {
        loadingComponent,
    },
    data() {
        return {
            products: [],
            is_end: false,
        };
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            this.$refs.loading.dialog = true;
            axios
                .get("/api/products")
                .then((response) => {
                    this.products = response.data;
                    console.log("ОТВЕТ API продуктов ", this.products);
                    this.is_end = true;
                })
                .catch((error) => {
                    console.error("Ошибка при загрузке товаров:", error);
                })
                .finally(() => {
                    this.$refs.loading.dialog = false;
                });
        },
        deleteProduct(id) {
            this.$refs.loading.dialog = true; // Включаем индикатор загрузки
            axios
                .delete(`/api/products/${id}`)
                .then(() => {
                    this.getProducts(); // Обновляем список товаров после удаления
                })
                .catch((error) => {
                    console.error("Ошибка при удалении товара:", error);
                })
                .finally(() => {
                    this.$refs.loading.dialog = false; // Выключаем индикатор загрузки
                });
        },
    },
};
</script>

<style scoped>
.text-grey-darken-1 {
    color: #2f2f2e;
}
</style>
