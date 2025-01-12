<script setup lang="ts">
  import { FR_LANGUAGE } from '@/constants'
  import { useLanguageStore } from '@/stores/language'
  import NotFoundView from '@/views/NotFoundView.vue'

  useLanguageStore().setLanguage( FR_LANGUAGE )
</script>

<template>
  <NotFoundView />
</template>