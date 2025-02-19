<script setup lang="ts">
  import { RouterLink } from 'vue-router'
  import { useLanguageStore } from '@/stores/language'
  import { FR_LANGUAGE } from '@/constants'


  const lang = useLanguageStore()
</script>

<template>
  <RouterLink to="/">{{ lang.current === FR_LANGUAGE ? 'Accueil' : 'Home' }}</RouterLink>
</template>