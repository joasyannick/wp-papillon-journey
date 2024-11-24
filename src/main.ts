import { createApp } from 'vue'
import { createI18n } from 'vue-i18n'
import { createPinia } from 'pinia'
import App from '@/App.vue'
import router from '@/router'
import en from '@/locales/en.json'
import fr from '@/locales/fr.json'

const i18n = createI18n( { legacy: false, locale: 'en', messages: { en, fr } } )
const app = createApp( App )
app.use( createPinia() )
app.use( router )
app.use( i18n )
const dataElement = document.getElementById( 'papj-data' )
if ( dataElement ) {
  router.push( JSON.parse( dataElement.textContent! ).route )
}
app.mount( '#papj-vue' )