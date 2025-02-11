@@ -1,46 +0,0 @@
<template>
    <v-container v-if="product">
        <v-card class="pa-4">
            <v-card-title>Описание</v-card-title>
            <v-card-text>
                {{ product.description }}
            </v-card-text>

            <v-card-actions>
                <v-chip :color="product.is_completed ? 'green' : 'red'" dark>
                    {{ getStatus(product.is_completed) }}
                </v-chip>

                <v-spacer></v-spacer>
                
                <v-btn
                    color="blue"
                    outlined
                    :to="{ name: 'product.edit', params: { id: product.id } }"
                    text="Редактировать"
                    />
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
export default {
    name: "showProductComponent",
    components: {},
    data() {
        return {
            product: null,
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
                    this.product = result.data.data;
                })
                .catch((error) => {
                    console.error("ошибка загрузки данных:", error)
                });
        },
        getStatus(isCompleted) {
            if (isCompleted === 1) return "Done"
            if (isCompleted === 0) return "Not done"
            return "Unknown";
        },
    },
    watch: {},
};
</script>

<style></style>
