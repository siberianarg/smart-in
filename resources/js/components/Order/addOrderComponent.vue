<template>
    <div class="w-25">
        <div class="mb-1">
            <v-text-field
                class="mt-3"
                type="text"
                v-model="name"
                label="Название заказа"
                outlined
            />
        </div>
        <div class="mb-1">
            <v-text-field
                class="mt-3"
                type="number"
                v-model="price"
                label="Цена заказа (₸)"
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
                text="Создать заказ"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "addOrderComponent",
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
                .post("/api/orders", {
                    name: this.name,
                    price: this.price
                })
                .then(() => {
                    this.$router.push({ name: "order.index" });
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
