<script setup lang="ts">
  import { RouterView } from 'vue-router'
  import { ref } from 'vue'
  import * as constants from '@/constants'
  import Phone from '@/components/Phone.vue'
  import Apollon from '@/components/apps/apollon/Apollon.vue'
  import Aurore from '@/components/apps/aurore/Aurore.vue'
  import BelArgus from '@/components/apps/bel-argus/BelArgus.vue'
  import Diane from '@/components/apps/diane/Diane.vue'
  import Monarque from '@/components/apps/monarque/Monarque.vue'
  import Vulcain from '@/components/apps/vulcain/Vulcain.vue'
  import Settings from '@/components/apps/settings/Settings.vue'
  import PapillonJourney from '@/components/PapillonJourney.vue'

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
      if ( null === openedApp.value && apps.has( key ) ) {
        openedApp.value = key
      }
    }

  const onAppClosed = () => {
      openedApp.value = null
    }


</script>

<template>
  <RouterView />
  <component v-if="openedApp" :is="apps.get( openedApp )" @closed="onAppClosed" />
  <Phone @app-opened="onAppOpened"/>
  <PapillonJourney />
</template>

<style scoped>
</style>