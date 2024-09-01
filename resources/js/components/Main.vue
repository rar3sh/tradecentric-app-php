<script>
export default {
    name: 'Main'
}
</script>

<template>
    <h4 class="text-center">Order Application made by Rares for the future colleagues from Tradecentric (hopefully 😊)</h4>

    <nav class="nav justify-content-center route-menu">
        <RouterLink class="route-item" to="/orders">List Orders</RouterLink>
        <RouterLink class="route-item" to="/charts">Charts</RouterLink>
    </nav>

    <main>
        <RouterView />
    </main>
</template>

<style scoped>
.route-menu {
    margin: 5px;
    border: 1px solid black;
    background-color: cornsilk;
}
.route-item {
    font-size: x-large;
    margin: 0 4%;
}
</style>
