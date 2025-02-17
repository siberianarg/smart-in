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
                :value="price || ''"
                :rules="[v => v > 0 || 'Цена должна быть больше 0']"
                outlined
            />
        </div>
        <div class="mb-1">
            <v-btn
                :disabled="!isDisabled"
                @click="store"
                color="blue"
                outlined
                text="Создать товар"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "createProductComponent",
    components: {},
    data() {
        return {
            name: null,
            price: false,
        };
    },
    mounted() {},
    methods: {
        store() {
            axios
                .post("/api/products", {
                    name: this.name,
                    price: this.price
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
    computed: {
        isDisabled() {
            return this.name;
        },
    },
    watch: {},
};
</script>

<style scoped></style>
