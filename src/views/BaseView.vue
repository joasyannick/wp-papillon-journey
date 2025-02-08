<script setup lang="ts">
  import { RouterView } from 'vue-router'
  import { ref } from 'vue'
  import * as constants from '@/constants'
  import Phone from '@/components/Phone.vue'
  import Store from '@/components/apps/store/Store.vue'
  import Apollon from '@/components/apps/apollon/Apollon.vue'
  import Aurore from '@/components/apps/aurore/Aurore.vue'
  import BelArgus from '@/components/apps/bel-argus/BelArgus.vue'
  import Diane from '@/components/apps/diane/Diane.vue'
  import Monarque from '@/components/apps/monarque/Monarque.vue'
  import Vulcain from '@/components/apps/vulcain/Vulcain.vue'
  import Settings from '@/components/apps/settings/Settings.vue'
  import Hub from '@/components/apps/hub/Hub.vue'
  import Blog from '@/components/apps/blog/Blog.vue'
  import Skills from '@/components/apps/skills/Skills.vue'
  import GameMap from '@/components/apps/map/Map.vue'
  import PapillonJourney from '@/components/PapillonJourney.vue'

  const phoneUsed = ref< boolean >( false )
  const openedApp = ref< null | string >( null )

  const apps = new Map( [
      [ constants.STORE_ID, Store ],
      [ constants.APOLLON_ID, Apollon ],
      [ constants.AURORE_ID, Aurore ],
      [ constants.BEL_ARGUS_ID, BelArgus ],
      [ constants.DIANE_ID, Diane ],
      [ constants.MONARQUE_ID, Monarque ],
      [ constants.VULCAIN_ID, Vulcain ],
      [ constants.SETTINGS_ID, Settings ],
      [ constants.HUB_ID, Hub ],
      [ constants.BLOG_ID, Blog ],
      [ constants.SKILLS_ID, Skills ],
      [ constants.MAP_ID, GameMap ],
    ] )
  
  const onPhoneUseChanged = ( used: boolean ) => {
      phoneUsed.value = used
    }

  const onAppOpened = ( appId: string ) => {
      if ( null === openedApp.value && apps.has( appId ) ) {
        openedApp.value = appId
      }
    }

  const onAppClosed = () => {
      openedApp.value = null
    }
</script>

<template>
  <RouterView />
  <component v-if="openedApp" :key="openedApp" :is="apps.get( openedApp )" @closed="onAppClosed" />
  <Phone @phone-use-changed="onPhoneUseChanged" @app-opened="onAppOpened"/>
  <PapillonJourney :paused="phoneUsed" />
</template>

<style scoped>
</style>