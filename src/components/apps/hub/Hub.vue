<script setup lang="ts">
  import * as constants from '@/constants'
  import BaseApp from '@/components/apps/BaseApp.vue'

  const emit = defineEmits< { closed: [] } >()

  const onClosed = () => {
      emit( 'closed' )
    }
</script>

<template>
  <BaseApp :class="'papj-' + constants.HUB_ID" @closed="onClosed">
  </BaseApp>
</template>