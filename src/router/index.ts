import { createRouter, createWebHistory } from 'vue-router'
import { EN_LANGUAGE, FR_LANGUAGE } from '@/constants'
import { useLanguageStore } from '@/stores/language'
import DummyView from '@/views/DummyView.vue'
import BaseView from '@/views/BaseView.vue'
import HomeView from '@/views/HomeView.vue'
import AppsView from '@/views/AppsView.vue'
import AppView from '@/views/AppView.vue'
import BlogView from '@/views/BlogView.vue'
import DevView from '@/views/DevView.vue'
import LanguageView from '@/views/LanguageView.vue'
import NotFoundView from '@/views/NotFoundView.vue'

const router = createRouter( {
    history: createWebHistory( import.meta.env.BASE_URL ),
    routes: [
        {
            path: '/',
            name: 'home',
            component: DummyView,
            beforeEnter: ( _, __, next ) => next( FR_LANGUAGE === useLanguageStore().current ? { name: 'fr-home' } : { name: 'en-home' } )
          },
        {
            path: '/en',
            component: BaseView,
            beforeEnter: () => useLanguageStore().set( EN_LANGUAGE ),
            children: [
                {
                    path: '',
                    name: 'en-home',
                    component: HomeView,
                  },
                {
                    path: 'apps',
                    name: 'en-apps',
                    component: AppsView,
                  },
                {
                    path: 'apps/:app',
                    name: 'en-app',
                    component: AppView,
                  },
                {
                    path: 'apps/blog',
                    name: 'en-blog',
                    component: BlogView,
                    children: [
                        {
                            path: 'dev/:slug',
                            name: 'en-dev',
                            component: DevView
                          },
                        {
                            path: 'lang/:slug',
                            name: 'en-lang',
                            component: LanguageView
                          }
                      ]
                  }
              ]
          },
        {
            path: '/fr',
            component: BaseView,
            beforeEnter: () => useLanguageStore().set( FR_LANGUAGE ),
            children: [
                {
                    path: '',
                    name: 'fr-home',
                    component: HomeView,
                  },
                {
                    path: 'apps',
                    name: 'fr-apps',
                    component: AppsView,
                  },
                {
                    path: 'apps/:app',
                    name: 'fr-app',
                    component: AppView,
                  },
                {
                    path: 'apps/blog',
                    name: 'fr-blog',
                    component: BlogView,
                    children: [
                        {
                            path: 'dev/:slug',
                            name: 'fr-dev',
                            component: DevView
                          },
                        {
                            path: 'lang/:slug',
                            name: 'fr-lang',
                            component: LanguageView
                          }
                      ]
                  }
              ]
          },
        {
            path: '/404',
            name: 'not-found',
            component: NotFoundView
          }
      ]
  } )

export default router
