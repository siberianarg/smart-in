<template>
    <v-app>
        <!-- Боковое меню -->
        <v-navigation-drawer app permanent class="bg-light-subtle text-light-emphasis">
            <v-list>
                <v-list-item
                    title="SMART INNOVATIONS"
                    class="text-h6 font-weight-bold"
                ></v-list-item>
                <v-divider></v-divider>

                <v-list-item
                    v-for="(item, index) in menuItems"
                    :key="index"
                    :to="item.route"
                    link
                >
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!-- Верхняя панель -->
        <v-app-bar app>
            <v-toolbar-title
                class="text-blue text-right font-weight-bold mr-4"
                style="margin-left: auto"
            >
                SMART INNOVATIONS
            </v-toolbar-title>
        </v-app-bar>

        <!-- Основной контент -->
        <v-main>
            <v-btn
                color="blue"
                outlined
                class="mr-2"
                :to="{ name: 'task.index' }"
            >
                Задачи
            </v-btn>
            <v-btn color="green" outlined :to="{ name: 'task.add' }">
                Создать задачу
            </v-btn>
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: "AppComponent",
    components: {},
    data() {
        return {
            drawer: true, // Открытое меню по умолчанию
            menuItems: [
                { title: "Задачи", route: "/tasks" },
                { title: "Товары", route: "/products" },
            ],
        };
    },
    mounted() {},
    methods: {},
    watch: {},
};
</script>

<style scoped>
/* Дополнительные стили */
</style>
