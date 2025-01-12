<script setup lang="ts">
  import { FR_LANGUAGE } from '@/constants'
  import { useLanguageStore } from '@/stores/language'
  import BaseView from '@/views/BaseView.vue'

  useLanguageStore().setLanguage( FR_LANGUAGE )
</script>

<template>
  <BaseView />
</template>