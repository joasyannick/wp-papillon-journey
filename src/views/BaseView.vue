<script setup lang="ts">
  import { RouterView } from 'vue-router'
  import { useLanguageStore } from '@/stores/language'

  const languageStore = useLanguageStore()
</script>

<template>
  <main>
    <RouterView />
  </main>
</template>