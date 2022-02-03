<template>
    <div>
        <nav class="navbar bg-white border-bottom navbar-light">
            <router-link class="navbar-brand mr-auto" :to="{name: 'home'}">Laravel BnB</router-link>
        </nav>

        <div class="container mt-4 mb-4 pr-4 pl-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script setup>

</script>

<style lang="scss" scoped>

</style>