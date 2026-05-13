<template>
  <div id="app">
    <AppNavbar />
    <main class="container">
      <router-view />
    </main>
  </div>
</template>

<script setup>
  import AppNavbar from './components/AppNavbar.vue'
</script>

<style scoped></style>
