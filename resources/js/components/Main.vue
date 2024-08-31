<script>
export default {
    name: 'Main'
}
</script>

<template>
    <h3 class="text-center">Order Application made by Rares for the colleagues from Tradecentric (hopefully 😊)</h3>
    <hr>
    <nav class="nav justify-content-center route-menu">
        <RouterLink class="route-item" to="/orders">List Orders</RouterLink>
        <RouterLink class="route-item" to="/charts">Charts</RouterLink>
        <hr>
    </nav>

    <main>
        <RouterView />
    </main>
</template>

<style scoped>
.route-menu {
    margin: 15px;
    border-bottom: 1px solid black;
}
.route-item {
    font-size: x-large;
    margin: 0 4%;
}
</style>
