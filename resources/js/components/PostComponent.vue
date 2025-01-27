<template>
    <div>
        <thirdComponent> </thirdComponent>
    </div>
</template>

<script>
import axios from "axios";
import thirdComponent from "./thirdComponent.vue";
export default {
    name: "postComponent",
    components: {
        thirdComponent,
    },
    data() {
        return {};
    },

    mounted() {
        this.getPosts()
    },

    methods: {
        getPosts() {
            axios.get("/posts")
            .then(function (data) {
                console.log(data.data );
            });
        },
    },
    computed: {},
    watch: {},
};
</script>

<style scoped></style>
