import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import UpdateView from '@/views/UpdateView.vue' 

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
      { path: '/', component: HomeView },
      { path: '/updates/:slug', component: UpdateView }
    ]
})

export default router
