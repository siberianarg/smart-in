<template>
    <v-container>
        <v-card class="pa-5">
            <v-card-title>Создание заказа</v-card-title>
            <v-card-text>
                <v-form ref="orderForm" v-model="valid">
                    <!-- Название заказа -->
                    <v-text-field
                        v-model="name"
                        label="Название заказа"
                        outlined
                        dense
                        :rules="[v => !!v || 'Название обязательно']"
                    />

                    <!-- Цена заказа -->
                    <v-text-field
                        v-model="price"
                        label="Цена заказа (₸)"
                        type="number"
                        outlined
                        dense
                        :rules="[v => v > 0 || 'Цена должна быть больше 0']"
                    />

                    <!-- Организация -->
                    <v-autocomplete
                        v-model="organization"
                        :items="organizations"
                        item-value="id"
                        item-text="name"
                        label="Выберите организацию"
                        outlined
                        dense
                        :rules="[v => !!v || 'Организация обязательна']"
                    />

                    <!-- Канал продаж -->
                    <v-autocomplete
                        v-model="salesChannel"
                        :items="salesChannels"
                        item-value="id"
                        item-text="name"
                        label="Выберите канал продаж"
                        outlined
                        dense
                    />

                    <!-- Проект -->
                    <v-autocomplete
                        v-model="project"
                        :items="projects"
                        item-value="id"
                        item-text="name"
                        label="Выберите проект"
                        outlined
                        dense
                    />

                    <!-- Товары -->
                    <v-select
                        v-model="selectedProducts"
                        :items="products"
                        item-value="id"
                        item-text="name"
                        label="Выберите товары"
                        multiple
                        outlined
                        dense
                        chips
                    />

                    <!-- Кнопка отправки -->
                    <v-btn
                        :disabled="!valid"
                        @click="store"
                        color="blue"
                        class="mt-4"
                        block
                        >Создать заказ</v-btn
                    >
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import axios from "axios";

export default {
    name: "AddOrderComponent",
    data() {
        return {
            name: "",
            price: null,
            organization: null,
            salesChannel: null,
            project: null,
            selectedProducts: [],
            organizations: [],
            salesChannels: [],
            projects: [],
            products: [],
            valid: false,
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async fetchData() {
            try {
                const [orgRes, salesRes, projRes, prodRes] = await Promise.all([
                    axios.get("/api/orders/organizations"),
                    axios.get("/api/orders/sales-channels"),
                    axios.get("/api/orders/projects"),
                    axios.get("/api/orders/products"),
                ]);

                this.organizations = orgRes.data;
                this.salesChannels = salesRes.data;
                this.projects = projRes.data;
                this.products = prodRes.data.map((p) => ({
                    id: p.id,
                    name: `${p.name} (Доступно: ${p.quantity}, Цена: ${p.price})`,
                }));
            } catch (error) {
                console.error("Ошибка при загрузке данных:", error);
            }
        },
        store() {
            axios
                .post("/api/orders", {
                    name: this.name,
                    price: this.price,
                    organization: this.organization,
                    salesChannel: this.salesChannel,
                    project: this.project,
                    positions: this.selectedProducts.map((id) => ({
                        product_id: id,
                        quantity: 1, // Здесь можно добавить логику выбора количества
                        price: this.products.find((p) => p.id === id)?.price || 0,
                    })),
                })
                .then(() => {
                    this.$router.push({ name: "order.index" });
                })
                .catch((error) => {
                    console.error("Ошибка при создании заказа:", error.response ? error.response.data : error.message);
                });
        },
    },
};
</script>

<style scoped></style>
