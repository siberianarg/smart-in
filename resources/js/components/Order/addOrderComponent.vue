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
                        :rules="[(v) => !!v || 'Название обязательно']"
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
                        :loading="loading.organizations"
                        :error="!!errors.organizations"
                        :error-messages="errors.organizations"
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
                        :loading="loading.salesChannels"
                        :error="!!errors.salesChannels"
                        :error-messages="errors.salesChannels"
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
                        :loading="loading.projects"
                        :error="!!errors.projects"
                        :error-messages="errors.projects"
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
                        :loading="loading.products"
                        :error="!!errors.products"
                        :error-messages="errors.products"
                    />

                    <!-- Итоговая цена -->
                    <v-text-field
                        :value="totalPrice"
                        label="Общая сумма заказа (₸)"
                        readonly
                        outlined
                        dense
                    />

                    <!-- Кнопка отправки -->
                    <v-btn @click="store" color="blue" class="mt-4" block
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
            organization: [],
            salesChannel: [],
            project: [],
            selectedProducts: [],
            organizations: [],
            salesChannels: [],
            projects: [],
            products: [],
            valid: false,
            loading: {
                organizations: false,
                salesChannels: false,
                projects: false,
                products: false,
            },
            errors: {
                organizations: "",
                salesChannels: "",
                projects: "",
                products: "",
            },
        };
    },
    computed: {
        totalPrice() {
            return this.selectedProducts.reduce((sum, id) => {
                const product = this.products.find((p) => p.id === id);
                return sum + (product?.price || 0);
            }, 0);
        },
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async fetchData() {
            try {
                this.loading.organizations = true;
                this.loading.salesChannels = true;
                this.loading.projects = true;
                this.loading.products = true;

                const [orgRes, salesRes, projRes, prodRes] = await Promise.all([
                    axios.get("/api/organizations"),
                    axios.get("/api/sales-channels"),
                    axios.get("/api/projects"),
                    axios.get("/api/products"),
                ]);

                this.organizations = orgRes.data.length ? orgRes.data : [];
                console.log("OOOORGAN", this.organizations[4].name);
                this.salesChannels = salesRes.data.length ? salesRes.data : [];
                console.log("канал", this.salesChannels[0].name);
                this.projects = projRes.data.length ? projRes.data : [];
                console.log("Проект", this.projects[0].name);
                this.products = (prodRes.data.length ? prodRes.data : []).map(
                    (p) => ({
                        id: p.id,
                        name: `${p.name} (Доступно: ${p.quantity}, Цена: ${p.price})`,
                        price: p.price,
                    })
                );
            } catch (error) {
                console.error("Ошибка при загрузке данных:", error);
                this.errors.organizations =
                    error.response?.data?.error ||
                    "Ошибка загрузки организаций";
                this.errors.salesChannels =
                    error.response?.data?.error ||
                    "Ошибка загрузки каналов продаж";
                this.errors.projects =
                    error.response?.data?.error || "Ошибка загрузки проектов";
                this.errors.products =
                    error.response?.data?.error || "Ошибка загрузки товаров";
            } finally {
                this.loading.organizations = false;
                this.loading.salesChannels = false;
                this.loading.projects = false;
                this.loading.products = false;
            }
        },
        async store() {
            try {
                if (!this.organization)
                    throw new Error("Организация не выбрана!");
                if (!this.selectedProducts.length)
                    throw new Error("Выберите хотя бы один товар!");

                const response = await axios.post("/api/orders", {
                    name: this.name,

                    organization: {
                        meta: {
                            href: `https://api.moysklad.ru/api/remap/1.2/entity/organization/${this.organization}`,
                            type: "organization",
                            mediaType: "application/json",
                        },
                    },

                    agent: {
                        meta: {
                            href: "https://api.moysklad.ru/api/remap/1.2/entity/counterparty/1e999adb-d141-11ec-0a80-075e00bbab3a",
                            type: "counterparty",
                            mediaType: "application/json",
                        },
                    },

                    salesChannel: this.salesChannel
                        ? {
                            meta: {
                                href: `https://api.moysklad.ru/api/remap/1.2/entity/saleschannel/${this.salesChannel}`,
                                type: "saleschannel",
                                mediaType: "application/json",
                            },
                        }
                        : null,

                    project: this.project
                        ? {
                            meta: {
                                href: `https://api.moysklad.ru/api/remap/1.2/entity/project/${this.project}`,
                                type: "project",
                                mediaType: "application/json",
                            },
                        }
                        : null,

                    positions: this.selectedProducts.map((id) => {
                        const product = this.products.find((p) => p.id === id);
                        return {
                            quantity: 1,
                            price: product.price ? product.price * 100 : 0, // Исправлено null → 0
                            assortment: {
                                meta: {
                                    href: `https://api.moysklad.ru/api/remap/1.2/entity/product/${product.id}`, // Исправлено отсутствие полного пути
                                    type: "product",
                                    mediaType: "application/json",
                                },
                            },
                        };
                    }),
                });

                console.log("Заказ создан:", response.data);
                this.$router.push({ name: "order.index" });
            } catch (error) {
                console.error(
                    "Ошибка при создании заказа:",
                    error.response?.data || error.message
                );
            }
        },
    },
};
</script>

<style scoped></style>
