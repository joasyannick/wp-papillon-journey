<script setup lang="ts">
  const emit = defineEmits< { closed: [] } >()

  const onCloseButtonClicked = () => {
      emit( 'closed' )
    }
</script>

<template>
  <aside class="papj-app">
    <button type="button" @click="onCloseButtonClicked">X</button>
    <slot></slot>
  </aside>
</template>

<style scoped>
  aside.papj-app {
    position: absolute;
    z-index: 2;
    inset: 0;
    overflow: clip;
    background-color: black;
  }
</style>