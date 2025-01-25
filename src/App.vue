<script setup lang="ts">
  import { RouterView } from 'vue-router'
</script>

<template>
  <div id="papj-app">
    <RouterView />
  </div>
</template>

<style scoped>
  div#papj-app {
    position: absolute;
    inset: 0;
    overflow: clip;
  }
</style>
