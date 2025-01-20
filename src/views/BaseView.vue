<script setup lang="ts">
  import { RouterView } from 'vue-router'
  import { onMounted, ref } from 'vue'
  import Two from 'two.js'
  import PhoneIcon from '@/components/icons/Phone.vue'
  import Apollon from '@/components/apps/apollon/Apollon.vue'
  import Aurore from '@/components/apps/aurore/Aurore.vue'
  import BelArgus from '@/components/apps/bel-argus/BelArgus.vue'
  import Diane from '@/components/apps/diane/Diane.vue'
  import Monarque from '@/components/apps/monarque/Monarque.vue'
  import Vulcain from '@/components/apps/vulcain/Vulcain.vue'
  import Settings from '@/components/apps/settings/Settings.vue'

  const game = ref< HTMLElement | null >( null )
  const currentApp = ref<string | null>(null)
  const apps = new Map( [
      [ 'Apollon', { name: 'Apollon', component: Apollon } ],
      [ 'Aurore', { name: 'Aurore', component: Aurore } ],
      [ 'BelArgus', { name: 'BelArgus', component: BelArgus } ],
      [ 'Diane', { name: 'Diane', component: Diane } ],
      [ 'Monarque', { name: 'Monarque', component: Monarque } ],
      [ 'Vulcain', { name: 'Vulcain', component: Vulcain } ],
      [ 'Settings', { name: 'Settings', component: Settings } ]
    ] )

  const loadApp = ( key: string ) => {
      if ( currentApp.value !== key) {
        currentApp.value = key
      }
    }

  const closeApp = () => {
      currentApp.value = null
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
  <main id="papj-main">
    <article id="papj-current-app" v-if="currentApp">
      <component :is="apps.get( currentApp )?.component" @close="closeApp" />
    </article>
    <aside id="papj-device">
      <PhoneIcon />
      <ul class="papj-apps">
        <li v-for="[ key, app ] in apps" :key="key" :class="`papj-${ key }-launcher`" @click="loadApp( key )">{{ app.name }}</li>
      </ul>
      <RouterView />
    </aside>
    <article id="papj-game" ref="game">
    </article>
  </main>
</template>