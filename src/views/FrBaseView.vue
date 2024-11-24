<script setup lang="ts">
  import BaseView from '@/views/BaseView.vue'
  import { RouterLink } from 'vue-router'
  import { FR_LANGUAGE } from '@/constants';
  import { useLanguageStore } from '@/stores/language'
  useLanguageStore().setLanguage( FR_LANGUAGE )
</script>

<template>
  <RouterLink to="/fr/dev/test">Test FR</RouterLink>
  <BaseView />
</template>