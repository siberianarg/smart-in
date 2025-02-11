<template>
    <div class="w-25">
        <div class="mb-1">
            <v-text-field
                class="mt-3"
                type="text"
                v-model="description"
                label="description"
                outlined
            />
        </div>
        <div class="mb-1">
            <!-- <v-text-field type="number" v-model="is_completed" label="status" outlined /> -->
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
import axios from "axios"

export default {
    name: "editProductComponent",
    components: {},
    data() {
        return {
            description: null,
            is_completed: false
        };
    },
    mounted() {
        this.getProduct()
    },
    methods: {
        getProduct() {
            axios
                .get(`/api/products/${this.$route.params.id}`)
                .then((result) => {
                    this.description = result.data.data.description
                    this.is_completed = result.data.data.status
                })
                .catch((error) => {
                    console.error("ошибка загрузки данных:", error)
                });
        },
        updateProduct() {
            axios
                .post(`/api/products/${this.$route.params.id}`, {
                    description: this.description,
                    isCompleated: this.isCompleated,
                })
                .then(() => {
                    // alert(`данные ${this.description} успешно обновлены`);
                    this.$router.push({ name: "product.index" })
                })
                .catch((error) => {
                    console.error("Ошибка обновления:", error)
                })
        },
    },
    computed: {
        isDisabled() {
            return this.description
        }
    }
}
</script>

<style></style>
