import { createRouter, createWebHashHistory } from 'vue-router'
import paginaInici from '../views/paginaInici.vue'
import whoAmI from '../views/whoAmI.vue'
import logIn from '../views/logIn.vue'
import register from '../views/registerR.vue'

const routes = [
  {
    path: '/',
    name: 'paginaInici',
    component: paginaInici
  },
  {
    path: '/whoAmI',
    name: 'whoAmI',
    component: whoAmI
  },
  {
    path: '/logIn',
    name: 'logIn',
    component: logIn
  },{
    path: '/register',
    name: 'register',
    component: register
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
