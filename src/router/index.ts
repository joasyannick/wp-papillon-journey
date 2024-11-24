import { createRouter, createWebHistory } from 'vue-router'
import BaseView from '@/views/BaseView.vue'
import HomeView from '@/views/HomeView.vue'
import NotFoundView from '@/views/NotFoundView.vue'
import EnBaseView from '@/views/EnBaseView.vue'
import EnHomeView from '@/views/EnHomeView.vue'
import EnNotFoundView from '@/views/EnNotFoundView.vue'
import EnDevView from '@/views/EnDevView.vue'
import FrBaseView from '@/views/FrBaseView.vue'
import FrHomeView from '@/views/FrHomeView.vue'
import FrNotFoundView from '@/views/FrNotFoundView.vue'
import FrDevView from '@/views/FrDevView.vue'

const router = createRouter( {
    history: createWebHistory( import.meta.env.BASE_URL ),
    routes: [
        {
            path: '/',
            component: BaseView,
            children: [
                {
                    path: '',
                    name: 'home',
                    component: HomeView
                  },
                {
                    path: '404',
                    name: 'not-found',
                    component: NotFoundView
                  },
                {
                    path: 'en',
                    component: EnBaseView,
                    children: [
                        {
                            path: '',
                            name: 'en-home',
                            component: EnHomeView,
                          },
                        {
                            path: '404',
                            name: 'en-not-found',
                            component: EnNotFoundView,
                          },
                        {
                            path: 'dev/:slug',
                            name: 'en-dev',
                            component: EnDevView,
                          }
                      ],
                  },
                {
                    path: 'fr',
                    component: FrBaseView,
                    children: [
                        {
                            path: '',
                            name: 'fr-home',
                            component: FrHomeView,
                          },
                        {
                            path: '404',
                            name: 'fr-not-found',
                            component: FrNotFoundView,
                          },
                        {
                            path: 'dev/:slug',
                            name: 'fr-dev',
                            component: FrDevView,
                          },
                      ],
                  }
              ]
          }
      ],
  } )

export default router
