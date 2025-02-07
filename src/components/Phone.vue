<script setup lang="ts">
  import { ref } from 'vue'
  import * as constants from '@/constants'
  import ApollonIcon from '@/components/apps/apollon/icons/Apollon.vue'
  import AuroreIcon from '@/components/apps/aurore/icons/Aurore.vue'
  import BelArgusIcon from '@/components/apps/bel-argus/icons/BelArgus.vue'
  import DianeIcon from '@/components/apps/diane/icons/Diane.vue'
  import MonarqueIcon from '@/components/apps/monarque/icons/Monarque.vue'
  import VulcainIcon from '@/components/apps/vulcain/icons/Vulcain.vue'
  import SettingsIcon from '@/components/apps/settings/icons/Settings.vue'
  import HubIcon from '@/components/apps/hub/icons/Hub.vue'
  import JoasIcon from '@/components/apps/joas/icons/Joas.vue'
  import MapIcon from '@/components/apps/map/icons/Map.vue'
  import StoreIcon from '@/components/apps/store/icons/Store.vue'
  import PhoneIcon from '@/components/icons/Phone.vue'

  const emit = defineEmits< { appStarted: [ appId: string ] } >()

  const held = ref( false )

  const CLASS_PREFIX = 'papj-app-'

  const apps = new Map( [
      [ constants.APOLLON_ID, { name: constants.APOLLON_APP, icon: ApollonIcon, class: CLASS_PREFIX + constants.APOLLON_ID } ],
      [ constants.AURORE_ID, { name: constants.AURORE_APP, icon: AuroreIcon, class: CLASS_PREFIX + constants.AURORE_ID } ],
      [ constants.BEL_ARGUS_ID, { name: constants.BEL_ARGUS_APP, icon: BelArgusIcon, class: CLASS_PREFIX + constants.BEL_ARGUS_ID } ],
      [ constants.DIANE_ID, { name: constants.DIANE_APP, icon: DianeIcon, class: CLASS_PREFIX + constants.DIANE_ID } ],
      [ constants.MONARQUE_ID, { name: constants.MONARQUE_APP, icon: MonarqueIcon, class: CLASS_PREFIX + constants.MONARQUE_ID } ],
      [ constants.VULCAIN_ID, { name: constants.VULCAIN_APP, icon: VulcainIcon, class: CLASS_PREFIX + constants.VULCAIN_ID } ],
      [ constants.SETTINGS_ID, { name: constants.SETTINGS_APP, icon: SettingsIcon, class: CLASS_PREFIX + constants.SETTINGS_ID } ]
    ] )

  const featuredApps = new Map( [
      [ constants.HUB_ID, { icon: HubIcon, class: CLASS_PREFIX + constants.HUB_ID } ],
      [ constants.JOAS_ID, { icon: JoasIcon, class: CLASS_PREFIX + constants.JOAS_ID } ],
      [ constants.MAP_ID, { icon: MapIcon, class: CLASS_PREFIX + constants.MAP_ID } ],
      [ constants.STORE_ID, { icon: StoreIcon, class: CLASS_PREFIX + constants.STORE_ID } ]
    ] )

  const hold = () => {
      held.value = true
    }

  const startApp = ( appId: string ) => {
      emit( 'appStarted', appId )
    }
</script>

<template>
  <header id="papj-phone">
    <section id="papj-apps" v-if="held">
      <section id="papj-favorite-apps">
        <label v-for="[ appId, app ] in apps" :key="appId" :class="app.class"><button type="button" @click="startApp( appId )"><component :key="appId" :is="app.icon"/></button><span>{{ app.name }}</span></label>
      </section>
      <section id="papj-featured-apps">
        <label v-for="[ appId, app ] in featuredApps" :key="appId" :class="app.class"><button type="button" @click="startApp( appId )"><component :key="appId" :is="app.icon"/></button></label>
      </section>
    </section>
    <button id="papj-phone-button" type="button" @click="hold">
      <PhoneIcon />
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