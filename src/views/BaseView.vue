<script setup lang="ts">
  import { RouterView } from 'vue-router'
  import { onMounted, ref } from 'vue'
  import Two from 'two.js'
  import * as constants from '@/constants'
  import Phone from '@/components/Phone.vue'
  import Apollon from '@/components/apps/apollon/Apollon.vue'
  import Aurore from '@/components/apps/aurore/Aurore.vue'
  import BelArgus from '@/components/apps/bel-argus/BelArgus.vue'
  import Diane from '@/components/apps/diane/Diane.vue'
  import Monarque from '@/components/apps/monarque/Monarque.vue'
  import Vulcain from '@/components/apps/vulcain/Vulcain.vue'
  import Settings from '@/components/apps/settings/Settings.vue'

  const game = ref< HTMLElement | null >( null )

  const openedApp = ref< string | null >( null )

  const apps = new Map( [
      [ constants.APOLLON_KEY, Apollon ],
      [ constants.AURORE_KEY, Aurore ],
      [ constants.BEL_ARGUS_KEY, BelArgus ],
      [ constants.DIANE_KEY, Diane ],
      [ constants.MONARQUE_KEY, Monarque ],
      [ constants.VULCAIN_KEY, Vulcain ],
      [ constants.SETTINGS_KEY, Settings ]
    ] )

  const onAppOpened = ( key: string ) => {
      if ( null === openedApp.value ) {
        openedApp.value = key
      }
    }

  const onAppClosed = () => {
      openedApp.value = null
    }

  onMounted( () => {
      const two = new Two( {
          type: Two.Types.canvas,
          fullscreen: true
        } ).appendTo( game.value! )

      // Create a triangle
      const triangle = two.makePolygon( 400, 300, 50, 3 ) // x, y, radius, sides
      triangle.stroke = "#ff0000"
      triangle.fill = "#ffcccc"
      triangle.linewidth = 4

      two.bind( "update", () => {
          triangle.rotation += 0.02 // Rotate the triangle
        } ).play()
    } )
</script>

<template>
  <RouterView />
  <component v-if="openedApp && apps.has( openedApp )" :is="apps.get( openedApp )" @closed="onAppClosed" />
  <Phone @app-opened="onAppOpened"/>
  <main id="papj-game" ref="game">
  </main>
</template>

<style scoped>
</style>