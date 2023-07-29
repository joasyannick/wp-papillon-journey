<script setup lang="ts">
  import { RouterLink, RouterView } from 'vue-router'
  import { useMapStore } from './stores/map'
  import "leaflet/dist/leaflet.css"
  import { LMap, LTileLayer } from "@vue-leaflet/vue-leaflet"
  const  mapStore = useMapStore()
</script>

<script lang="ts">
  export default {
    components: {
      LMap,
      LTileLayer,
    },
    data() {
      return {
        zoom: 2,
        url: ''
      }
    },
    created() {
      fetch(import.meta.env.VITE_WP_REST_URL + 'papillon-journey/v1/map/tiles')
        .then(response => response.json())
        .then(data => console.log( data ) )
    },
  }
</script>

<template>
  <header class="papj-header">
    <h1>Papillon Journey</h1>
    <img alt="Vue logo" src="" width="125" height="125" @click="mapStore.openOrClose()"/>
    <nav v-show="mapStore.opened" style="height:600px; width:800px">
      <l-map ref="map" v-model:zoom="zoom" :center="[47.41322, -1.219482]">
        <l-tile-layer :url="url">
        </l-tile-layer>
      </l-map>
    </nav>
  </header>
  <main>
    <RouterView />
  </main>
</template>

<style scoped>
  header.papj-header {
    position: absolute;
  }

  header.papj-header > h1 {
    font: 16px/calc(16px * 1.5) 'DM Serif Display', serif;
  }

  header.papj-header > nav {
    position: absolute;
  }
</style>
