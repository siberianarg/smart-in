<template>
    <div class="w-25">
        <div class="mb-1">
            <v-text-field
                class="mt-3"
                type="text"
                v-model="name"
                label="Название товара"
                outlined
            />
        </div>
        <div class="mb-1">
            <v-text-field
                class="mt-3"
                type="number"
                v-model="price"
                label="Цена товара (₸)"
                outlined
            />
        </div>
        <div class="mb-1">
            <v-btn
                :disabled="!isDisabled"
                @click="updateProduct"
                color="blue"
                outlined
                text="Изменить товар"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "editProductComponent",
    data() {
        return {
            name: null,
            price: null,
        };
    },
    mounted() {
        this.getProduct();
    },
    methods: {
        getProduct() {
            axios
                .get(`/api/products/${this.$route.params.id}`)
                .then((result) => {
                    this.name = result.data.name;
                    this.price = result.data.salePrices[0]?.value / 100;
                })
                .catch((error) => {
                    console.error("Ошибка загрузки данных:", error);
                });
        },
        updateProduct() {
            axios
                .put(`/api/products/${this.$route.params.id}`, {
                    name: this.name,
                    price: this.price,
                })
                .then(() => {
                    this.$router.push({ name: "product.index" });
                })
                .catch((error) => {
                    console.error("Ошибка обновления:", error);
                });
        },
    },
    computed: {
        isDisabled() {
            return this.name && this.price !== null;
        },
    },
};
</script>

<style scoped></style>
