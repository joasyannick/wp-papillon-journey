<script setup lang="ts">
  import { EN_LANGUAGE } from '@/constants'
  import { useLanguageStore } from '@/stores/language'
  import NotFoundView from '@/views/NotFoundView.vue'

  useLanguageStore().setLanguage( EN_LANGUAGE )
</script>

<template>
  <NotFoundView />
</template>