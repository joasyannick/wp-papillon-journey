import { createRouter, createWebHistory } from 'vue-router'
import { FR_LANGUAGE } from '@/constants'
import { useLanguageStore } from '@/stores/language'
import EnBaseView from '@/views/EnBaseView.vue'
import EnHomeView from '@/views/EnHomeView.vue'
import EnNotFoundView from '@/views/EnNotFoundView.vue'
import EnDevView from '@/views/EnDevView.vue'
import FrBaseView from '@/views/FrBaseView.vue'
import FrHomeView from '@/views/FrHomeView.vue'
import FrNotFoundView from '@/views/FrNotFoundView.vue'
import FrDevView from '@/views/FrDevView.vue'
import DummyView from '@/views/DummyView.vue'

const router = createRouter( {
    history: createWebHistory( import.meta.env.BASE_URL ),
    routes: [
        {
            path: '/',
            name: 'home',
            component: DummyView,
            beforeEnter: ( _, __, next ) => next( FR_LANGUAGE === useLanguageStore().language ? { name: 'fr-home' } : { name: 'en-home' } )
          },
        {
            path: '/en',
            component: EnBaseView,
            children: [
                {
                    path: '',
                    name: 'en-home',
                    component: EnHomeView,
                  },
                {
                    path: 'dev/:slug',
                    name: 'en-dev',
                    component: EnDevView,
                  }
              ]
          },
        {
            path: '/fr',
            component: FrBaseView,
            children: [
                {
                    path: '',
                    name: 'fr-home',
                    component: FrHomeView,
                  },
                {
                    path: 'dev/:slug',
                    name: 'fr-dev',
                    component: FrDevView,
                  }
              ]
          },
        {
            path: '/404',
            name: 'not-found',
            component: DummyView,
            beforeEnter: ( _, __, next ) => next( FR_LANGUAGE === useLanguageStore().language ? { name: 'fr-not-found' } : { name: 'en-not-found' } )
          },
        {
            path: '/en/404',
            name: 'en-not-found',
            component: EnNotFoundView
          },
        {
            path: '/fr/404',
            name: 'fr-not-found',
            component: FrNotFoundView
          }
      ]
  } )

export default router
