<template>
    <div class="w-25">
        <div class="mb-3">
            <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Disabled input"
            />
        </div>
        <div class="mb-3">
            <input
                type="number"
                class="form-control"
                id="agle"
                placeholder="Disabled input"
            />
        </div>
        <div class="mb-3">
            <input
                type="text"
                class="form-control"
                id="job"
                placeholder="Disabled input"
            />
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Добавить" />
        </div>
    </div>
</template>

<script>
export default {
    name: "createComponent",
};
</script>

<style scoped></style>
