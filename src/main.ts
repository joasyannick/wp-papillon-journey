import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const route = document.getElementById( 'papj-app' )!.dataset.papjRoute!
const app = createApp( App )
app.use( createPinia() )
app.use( router )
router.push( route )
app.mount( '#papj-app' )
