<script setup lang="ts">
  import { EN_LANGUAGE } from '@/constants'
  import { useLanguageStore } from '@/stores/language'
  import BaseView from '@/views/BaseView.vue'

  useLanguageStore().setLanguage( EN_LANGUAGE )
</script>

<template>
  <BaseView />
</template>