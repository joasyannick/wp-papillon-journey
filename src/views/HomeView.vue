<script setup lang="ts">
  import { useLanguageStore } from '@/stores/language'
  import { FR_LANGUAGE } from '@/constants'

  const lang = useLanguageStore()
</script>

<template>
  <div>{{ lang.current === FR_LANGUAGE ? 'France' : 'UK' }}</div>
</template>