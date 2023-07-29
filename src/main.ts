import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createI18n } from 'vue-i18n'
import en from './locales/en.json'
import fr from './locales/fr.json'

import 'leaflet' // Patch, should be able to remove it...

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(createI18n({
    legacy: false,
    locale: 'en',
    fallbackLocale: 'en',
    messages: {
      en: en,
      fr: fr
    }
  }))
app.use(router)

app.mount('#papj-app')
