<template>
    <v-app>
        <!-- Боковое меню -->
        <v-navigation-drawer app permanent class="bg-light-subtle text-light-emphasis">
            <v-list>
                <!-- Заголовок с логотипом -->
                <v-list-item>
                    <div style="display: flex; align-items: center">
                        <v-img
                            src="/fonts/uds-logo.jpeg"
                            width="50"
                            height="50"
                            style="object-fit: contain; border-radius: 8px"
                        ></v-img>
                        <span class="ml-3">UDS интернет магазин</span>
                    </div>
                </v-list-item>
                <v-divider></v-divider>

                <v-list-item
                    v-for="(item, index) in menuItems"
                    :key="index"
                    :to="item.route"
                    link
                >
                    <div style="display: flex; align-items: center">
                        <v-icon class="mr-3">{{ item.icon }}</v-icon>
                        <span>{{ item.title }}</span>
                    </div>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!-- Верхняя панель -->
        <v-app-bar app elevation="1">
            <v-toolbar-title class="text-blue text-right font-weight-bold mr-4">
                SMART INNOVATIONS
            </v-toolbar-title>
        </v-app-bar>

        <!-- Основной контент -->
        <v-main>
            <v-container class="pa-6">
                <router-view />
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: "AppComponent",
    data() {
        return {
            menuItems: [
                { title: "Задачи", route: "/tasks", icon: "mdi-clipboard-text" },
                { title: "Товары", route: "/products", icon: "mdi-shopping" },
                { title: "Заказы", route: "/orders", icon: "mdi-cart" },
            ],
        };
    },
};
</script>

<style scoped>
/* Добавляем отступ сверху, чтобы контент не перекрывался */
.v-main {
    padding-top: 20px;
}
</style>
