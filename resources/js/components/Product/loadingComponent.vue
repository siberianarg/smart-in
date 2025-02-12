<template>
    <v-dialog v-model="dialog" max-width="320" persistent>
        <v-list class="py-2" color="primary" elevation="12" rounded="lg">
            <v-list-item  title="Ожидаю получение данных!">
                <template v-slot:append>
                    <v-progress-circular color="primary" indeterminate="disable-shrink" size="16" width="2"></v-progress-circular>
                </template>
            </v-list-item>
        </v-list>
    </v-dialog>
</template>


<script>
export default {
    name: "loadingComponent",
    data() {
        return {
            dialog: false, // Добавили переменную для управления диалогом
        };
    },
};
</script>

