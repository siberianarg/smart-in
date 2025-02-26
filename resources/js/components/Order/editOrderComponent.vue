<template>
    <div v-if="order">
        <h1 class="mt-4 mb-2">Редактирование заказа #{{ order.name }}</h1>

        <v-form @submit.prevent="updateOrder">
            <v-text-field
                v-model="order.name"
                label="Название заказа"
                required
            ></v-text-field>
            <p><strong>Код:</strong> {{ order.externalCode }}</p>
            <p><strong>ID:</strong> {{ order.id }}</p>
            <p>
                <strong>Сумма:</strong> {{ order.sum + " " + order.currency }}
            </p>
            <p><strong>Контрагент:</strong> {{ order.customer }}</p>
            <p><strong>Адрес:</strong> {{ order.deliveryAddress }}</p>
            <v-text-field
                v-model="order.customer"
                label="контрагент"
                disabled
            ></v-text-field>
            <p><strong>Дата создания:</strong> {{ order.createdAt }}</p>

            <h2 style="background-color: #f2f2f2; padding: 10px;">Товары в заказе</h2>
            <v-table>
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Количество</th>
                        <th>Цена продажи</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(position, index) in order.positions"
                        :key="index"
                    >
                        <td>
                            <v-select
                                v-model="position.assortmentHref"
                                :items="products"
                                item-title="name"
                                item-value="meta.href"
                                label="Выберите товар"
                            ></v-select>
                        </td>
                        <td>
                            <v-text-field
                                v-model="position.quantity"
                                type="number"
                            ></v-text-field>
                        </td>
                        <td>
                            <v-text-field
                                v-model="position.price"
                                type="number"
                                disabled
                            ></v-text-field>
                        </td>
                        <td>
                            <v-btn color="red" @click="removeProduct(index)"
                                >Удалить</v-btn
                            >
                        </td>
                    </tr>
                </tbody>
            </v-table>

            <v-btn color="success" @click="addProduct">Добавить товар</v-btn>

            <v-btn class="ml-4" color="primary" type="submit">Сохранить</v-btn>
        </v-form>
    </div>
    <loading-component ref="loading" />
</template>

<script>
import axios from "axios";
import loadingComponent from "../loadingComponent.vue";

export default {
    name: "editOrderComponent",
    components: {
        loadingComponent,
    },
    props: ["id"],
    data() {
        return {
            order: null,
            newProduct: {
                name: "",
                quantity: 1,
                price: 0,
                assortmentHref: "",
            },
            products: [],
            is_end: false
        };
    },
    mounted() {
        this.fetchOrder();
        this.fetchProduct();
    },
    methods: {
        fetchProduct() {
            this.$refs.loading.dialog = true;
            axios
                .get("/api/products")
                .then((res) => {
                    this.products = res.data;
                })
                .catch((error) => {
                    console.log("ошибка загрузки товаров из заказа: ", error);
                })
                .finally(()=> {
                    this.$refs.loading.dialog = false;
                });
        },
        fetchOrder() {
            
            axios
                .get(`/api/orders/${this.id}`)
                .then((res) => {
                    console.log("Детали заказа:", res.data);
                    this.order = res.data;
                })
                .catch((error) => {
                    console.error("Ошибка загрузки заказа:", error);
                });
        },
        updateOrder() {
            axios
                .put(`/api/orders/${this.id}`, {
                    name: this.order.name,
                    customerHref: this.order.customerHref,
                    positions: this.order.positions.map((pos) => ({
                        quantity: pos.quantity,
                        price: pos.price,
                        assortmentHref: pos.assortmentHref,
                    })),
                })
                .then((res) => {
                    // console.log("Заказ обновлен:", res.data);
                    // alert("Заказ успешно обновлен!");
                    this.$router.push({ name: "order.index" });
                })
                .catch((error) => {
                    console.error("Ошибка при обновлении заказа:", error);
                    alert("Ошибка при обновлении заказа.");
                });
        },
        addProduct() {
            // const newItem = { ...this.newProduct };
            // this.order.positions.push(newItem);
            // this.newProduct = {
            //     name: "",
            //     quantity: 1,
            //     price: 0,
            //     assortmentHref: "",
            // };
            this.order.positions.push({
                assortmentHref: "",
                quantity: 1,
                price: 0,
            });
        },
        removeProduct(index) {
            this.order.positions.splice(index, 1);
        },
    },
};
</script>
