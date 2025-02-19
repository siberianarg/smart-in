<template>
    <div v-if="is_end">
        <h1 class="mt-4">Список заказов</h1>

        <v-table class="mt-2">
            <thead>
                <tr>
                    <th class="text-grey-darken-1">#</th>
                    <th class="text-grey-darken-1">Код</th>
                    <th class="text-grey-darken-1">Название</th>
                    <th class="text-grey-darken-1">Стоимость</th>
                    <th class="text-grey-darken-1">Клиент</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(order, index) in orders" :key="order.id">
                    <td>
                        <v-btn
                            :to="{
                                name: 'order.show',
                                params: { id: order.id },
                            }"
                            variant="plain"
                            color="black"
                        >
                            {{ index + 1 }}
                        </v-btn>
                    </td>
                    <td>{{ order.externalCode || "—" }}</td>
                    <td>
                        <v-btn
                            :to="{
                                name: 'order.edit',
                                params: { id: order.id },
                            }"
                            variant="plain"
                            color="black"
                        >
                            {{ order.name }}
                        </v-btn>
                    </td>
                    <td>
                        <v-chip :color="order.sum > 0 ? 'green' : 'red'" dark>
                            {{ order.sum }} ₸
                        </v-chip>
                    </td>
                    <td>
                        {{ order.customer || "-" }}
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
    name: "indexOrderComponent",
    components: {
        loadingComponent,
    },
    data() {
        return {
            orders: [],
            is_end: false,
        };
    },
    mounted() {
        this.getOrders();
    },
    methods: {
        getOrders() {
            this.$refs.loading.dialog = true;
            axios
                .get("/api/orders")
                .then((res) => {
                    this.orders = res.data;
                    console.log(
                        "ОТВЕТ API заказов:",
                        JSON.parse(JSON.stringify(this.orders))
                    );
                    console.log(
                        "Тип данных orders:",
                        Array.isArray(this.orders)
                    );
                    this.is_end = true;
                })
                .catch((error) => {
                    console.error("Ошибка при загрузке заказов:", error);
                })
                .finally(() => {
                    this.isLoading = false;
                    this.$refs.loading.dialog = false;
                });
        },
        deleteOrder(id) {
            this.$refs.loading.dialog = true;
            axios
                .delete(`/api/orders/${id}`)
                .then(() => {
                    this.getOrders(); // Обновляем список заказов после удаления
                })
                .catch((error) => {
                    console.error("Ошибка при удалении заказа:", error);
                })
                .finally(() => {
                    this.$refs.loading.dialog = false;
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
