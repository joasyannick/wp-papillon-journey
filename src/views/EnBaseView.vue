<script setup lang="ts">
  import BaseView from '@/views/BaseView.vue'
  import { RouterLink } from 'vue-router'
  import { EN_LANGUAGE } from '@/constants'
  import { useLanguageStore } from '@/stores/language'
  useLanguageStore().setLanguage( EN_LANGUAGE )
</script>

<template>
  <RouterLink to="/en/dev/test">Test EN</RouterLink>
  <BaseView />
</template>