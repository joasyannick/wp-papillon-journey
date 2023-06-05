import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useMapStore = defineStore('map', () => {
  const opened = ref(false)
  const closed = computed(() => !opened.value)
  function open() {
    if (!opened.value) {
      opened.value = true;
    }
  }
  function close() {
    if (opened.value) {
      opened.value = false;
    }
  }
  function openOrClose() {
    opened.value = !opened.value
  }
  return { opened, closed, open, close, openOrClose }
})