<template>
    <div v-if="is_end">
        <h1 class="mb-4">Список товаров</h1>
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
                        <v-btn
                            :to="{
                                name: 'product.show',
                                params: { id: product.id },
                            }"
                            variant="plain"
                            color="black"
                        >
                            {{ product.name }}
                        </v-btn>
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
                                    ? product.salePrices[0].value / 100 + " ₽"
                                    : "Нет цены"
                            }}
                        </v-chip>
                    </td>
                    <td>
                        <v-btn
                            class="mr-2"
                            color="blue"
                            outlined
                            :to="{
                                name: 'product.edit',
                                params: { id: product.id },
                            }"
                        >
                            Изменить
                        </v-btn>
                        <v-btn
                            color="red"
                            outlined
                            @click="deleteProduct(product.id)"
                        >
                            Удалить
                        </v-btn>
                    </td>
                </tr>
            </tbody>
        </v-table>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "indexProductComponent",
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
            axios
                .get("/api/products")
                .then((response) => {
                    this.products = response.data;
                    this.is_end = true;
                })
                .catch((error) => {
                    console.error("Ошибка при загрузке товаров:", error);
                });
        },
        deleteProduct(id) {
            axios
                .delete(`/api/products/${id}`, {product : this.product[id]})
                .then(() => {
                    this.getProducts();
                })
                .catch((error) => {
                    console.error("Ошибка при удалении товара:", error);
                });
        },
        formatDate(date) {
            const options = {
                year: "numeric",
                month: "numeric",
                day: "numeric",
                hour: "numeric",
                minute: "numeric",
            };
            return new Date(date).toLocaleString("ru-RU", options);
        },
    },
};
</script>

<style scoped>
.text-grey-darken-1 {
    color: #757575;
}
</style>
