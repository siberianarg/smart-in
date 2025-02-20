<template>
    <div v-if="product">
        <h1>Заказ {{ product.name }}</h1>
        <p><strong>ID:</strong> {{ product.id }}</p>
        <p><strong>Код:</strong> {{ product.code }}</p>
        <p><strong>Дата:</strong> {{ product.updated }}</p>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "showProductComponent",
    components: {  },
    props: ["id"],
    data() {
        return {
            product: {},
        };
    },
    mounted() {
        console.log(this.id)
        this.fetchProduct();
    },
    methods: {
        fetchProduct() {
            axios
                .get(`/api/products/${this.id}`)
                .then( (res) => {
                    console.log("Детали заказа:", res.data);
                    this.product = res.data;
                })
                .catch((error) => {
                    console.error("Ошибка загрузки товара:", error);
                })

        },
    },
};
</script>
