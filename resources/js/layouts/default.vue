<script setup>
import Sidebar from './components/Sidebar.vue'
</script>

<template>
  <Sidebar>
    <RouterView />
  </Sidebar>
</template>

<style lang="scss">
// As we are using `layouts` plugin we need its styles to be imported
@use '@layouts/styles/default-layout';
</style>
