<script setup lang="ts">
  import { ref } from 'vue'
  import * as constants from '@/constants'

  const emit = defineEmits< { appOpened: [ key: string ] } >()
  const held = ref( false )

  const apps = new Map( [
      [ constants.APOLLON_KEY, { name: "ApollonIcon", icon: "ApollonIcon" } ],
      [ constants.AURORE_KEY, { name: "AuroreIcon", icon: "AuroreIcon" } ],
      [ constants.BEL_ARGUS_KEY, { name: "BelArgusIcon", icon: "BelArgusIcon" } ],
      [ constants.DIANE_KEY, { name: "DianeIcon", icon: "DianeIcon" } ],
      [ constants.MONARQUE_KEY, { name: "MonarqueIcon", icon: "MonarqueIcon" } ],
      [ constants.VULCAIN_KEY, { name: "VulcainIcon", icon: "VulcainIcon" } ],
      [ constants.SETTINGS_KEY, { name: "SettingsIcon", icon: "SettingsIcon" } ]
    ] )
  
    const specialApps = new Map( [
      [ "close", { name: "", icon: "" } ],
      [ "Joas", { name: "", icon: "" } ],
      [ "hub", { name: "", icon: "" } ],
      [ "map", { name: "", icon: "" } ]
    ] )

  const hold = () => {
    if ( ! held.value ) {
      held.value = true
    }
  }

  const onPhoneButtonClicked = ( _: Event ) => hold()
</script>

<template>
  <header id="papj-phone">
    <section id="papj-apps" v-if="held">
      <label v-for="[key, app] in apps" :key="key">{{ app.name }}<button>{{ app.icon }}</button></label>
    </section>
    <button id="papj-phone-button" type="button" @click="onPhoneButtonClicked">
      <svg viewBox="0 -960 960 960">
        <path d="M280-40q-33 0-56.5-23.5T200-120v-720q0-33 23.5-56.5T280-920h400q33 0 56.5 23.5T760-840v720q0 33-23.5 56.5T680-40H280Zm0-200v120h400v-120H280Zm200 100q17 0 28.5-11.5T520-180q0-17-11.5-28.5T480-220q-17 0-28.5 11.5T440-180q0 17 11.5 28.5T480-140ZM280-320h400v-400H280v400Zm0-480h400v-40H280v40Zm0 560v120-120Zm0-560v-40 40Z"/>
      </svg>
    </button>
  </header>
</template>

<style scoped>
  header#papj-phone {
    position: absolute;
    z-index: 1;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  header#papj-phone > button {
    width: 50px;
  }
</style>