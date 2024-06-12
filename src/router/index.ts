import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import UpdateView from '@/views/UpdateView.vue'
import Error404 from '@/views/Error404.vue'

const router = createRouter( {
    history: createWebHistory( import.meta.env.BASE_URL ),
    routes: [
        { path: '/', component: HomeView },
        { path: '/updates/:slug', component: UpdateView },
        { path: '/404', component: Error404 }
      ]
  } )

export default router
