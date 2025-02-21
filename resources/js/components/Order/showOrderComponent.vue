<template>
    <div v-if="order">
        <h1>Заказ #{{ order.name }}</h1>
        <p><strong>Код:</strong> {{ order.externalCode }}</p>
        <p><strong>Сумма:</strong> {{ order.sum }} ₸</p>
        <p><strong>Клиент:</strong> {{ order.customer }}</p>
        <p><strong>Дата создания:</strong> {{ order.createdAt }}</p>

        <h2>Товары в заказе</h2>
        <v-table>
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Количество</th>
                    <th>Цена</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="position in order.positions" :key="position.id">
                    <td>{{ position.name || "—" }}</td>
                    <td>{{ position.quantity }}</td>
                    <td>{{ position.price / 100 }} ₸</td>
                </tr>
            </tbody>
        </v-table>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "showOrderComponent",
    components: {  },
    props: ["id"],
    data() {
        return {
            order: null,
        };
    },
    mounted() {
        this.fetchOrder();
    },
    methods: {
        fetchOrder() {
            axios
                .get(`/api/orders/${this.id}`)
                .then( (res) => {
                    console.log("Детали заказа:", res.data);
                    this.order = res.data;
                })
                .catch((error) => {
                    console.error("Ошибка загрузки заказа:", error);
                })
                .finally(() => {
                    
                });
        },
    },
};
</script>
