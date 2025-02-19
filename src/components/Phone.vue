<script setup lang="ts">
  import { ref, computed } from 'vue'
  import * as constants from '@/constants'
  import StoreIcon from '@/components/apps/store/icons/Store.vue'
  import ApollonIcon from '@/components/apps/apollon/icons/Apollon.vue'
  import AuroreIcon from '@/components/apps/aurore/icons/Aurore.vue'
  import BelArgusIcon from '@/components/apps/bel-argus/icons/BelArgus.vue'
  import DianeIcon from '@/components/apps/diane/icons/Diane.vue'
  import MonarqueIcon from '@/components/apps/monarque/icons/Monarque.vue'
  import VulcainIcon from '@/components/apps/vulcain/icons/Vulcain.vue'
  import SettingsIcon from '@/components/apps/settings/icons/Settings.vue'
  import HubIcon from '@/components/apps/hub/icons/Hub.vue'
  import BlogIcon from '@/components/apps/blog/icons/Blog.vue'
  import SkillsIcon from './apps/skills/icons/Skills.vue'
  import MapIcon from '@/components/apps/map/icons/Map.vue'
  import PhoneIcon from '@/components/icons/Phone.vue'

  // TODO: Apps are now called with RouterLink, so we need to update the way we handle the apps
  const emit = defineEmits< { phoneUseChanged: [ used: boolean ], appOpened: [ appId: string ] } >()

  const used = ref( false )

  const CLASS_PREFIX = 'papj-app-'

  const appStore = new Map( [
      [ constants.STORE_ID, { name: constants.STORE_APP, icon: StoreIcon, installed: true, featured: false, deletable: false, class: CLASS_PREFIX + constants.STORE_ID } ],
      [ constants.APOLLON_ID, { name: constants.APOLLON_APP, icon: ApollonIcon, installed: true, featured: false, deletable: true, class: CLASS_PREFIX + constants.APOLLON_ID } ],
      [ constants.AURORE_ID, { name: constants.AURORE_APP, icon: AuroreIcon, installed: true, featured: false, deletable: true, class: CLASS_PREFIX + constants.AURORE_ID } ],
      [ constants.BEL_ARGUS_ID, { name: constants.BEL_ARGUS_APP, icon: BelArgusIcon, installed: true, featured: false, deletable: true, class: CLASS_PREFIX + constants.BEL_ARGUS_ID } ],
      [ constants.DIANE_ID, { name: constants.DIANE_APP, icon: DianeIcon, installed: true, featured: false, deletable: true, class: CLASS_PREFIX + constants.DIANE_ID } ],
      [ constants.MONARQUE_ID, { name: constants.MONARQUE_APP, icon: MonarqueIcon, installed: true, featured: false, deletable: true, class: CLASS_PREFIX + constants.MONARQUE_ID } ],
      [ constants.VULCAIN_ID, { name: constants.VULCAIN_APP, icon: VulcainIcon, installed: true, featured: false, deletable: true, class: CLASS_PREFIX + constants.VULCAIN_ID } ],
      [ constants.SETTINGS_ID, { name: constants.SETTINGS_APP, icon: SettingsIcon, installed: true, featured: false, deletable: false, class: CLASS_PREFIX + constants.SETTINGS_ID } ],
      [ constants.HUB_ID, { name: constants.HUB_APP, icon: HubIcon, installed: true, featured: true, deletable: false, class: CLASS_PREFIX + constants.HUB_ID } ],
      [ constants.BLOG_ID, { name: constants.BLOG_APP, icon: BlogIcon, installed: true, featured: true, deletable: false, class: CLASS_PREFIX + constants.BLOG_ID } ],
      [ constants.SKILLS_ID, { name: constants.SKILLS_APP, icon: SkillsIcon, installed: true, featured: true, deletable: false, class: CLASS_PREFIX + constants.SKILLS_ID } ],
      [ constants.MAP_ID, { name: constants.MAP_APP, icon: MapIcon, installed: true, featured: true, deletable: false, class: CLASS_PREFIX + constants.MAP_ID } ]
    ] )

  const favoriteApps = computed( () => Array.from( appStore.entries() ).filter( ( [ , app ] ) => app.installed && ! app.featured ) )
  const featuredApps = computed( () => Array.from( appStore.entries() ).filter( ( [ , app ] ) => app.installed && app.featured && ! app.deletable ).slice( 0, 4 ) )

  const use = () => {
      used.value = true
      emit( 'phoneUseChanged', true )
    }
  
  const stopUsing = () => {
      used.value = false
      emit( 'phoneUseChanged', false )
    }

  const startApp = ( appId: string ) => {
      emit( 'appOpened', appId )
    }
</script>

<template>
  <header class="papj-phone">
    <nav class="papj-apps" v-if="used">
      <section class="papj-favorite-apps">
        <label v-for="[ appId, app ] in favoriteApps" :key="appId" :class="app.class"><button type="button" @click="startApp( appId )"><component :key="appId" :is="app.icon"/></button><span>{{ app.name }}</span></label>
      </section>
      <section class="papj-featured-apps">
        <label v-for="[ appId, app ] in featuredApps" :key="appId" :class="app.class"><button type="button" @click="startApp( appId )"><component :key="appId" :is="app.icon"/></button></label>
      </section>
      <button class="papj-stop-using" type="button" @click="stopUsing">X</button>
    </nav>
    <button class="papj-use" type="button" @click="use">
      <PhoneIcon />
    </button>
  </header>
</template>

<style scoped>
  header.papj-phone {
    position: absolute;
    z-index: 1;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  header.papj-phone > button.papj-use {
    width: 50px;
  }
</style>