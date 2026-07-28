import { createWebHistory, createRouter } from 'vue-router'

import HsProjectView from './views/HsProjectView.vue'
import HsRootView from './views/HsRootView.vue'

const routes = [
  { path: '/', component: HsRootView},
  { path: '/page', component: () => import('@/views/HsPageView.vue') , props: true},
  { path: '/auszug', component: HsProjectView },
]


const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router