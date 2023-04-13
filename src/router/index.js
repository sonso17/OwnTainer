import { createRouter, createWebHashHistory } from 'vue-router'
import paginaInici from '../views/paginaInici.vue'
import whoAmI from '../views/whoAmI.vue'
import logIn from '../views/logIn.vue'
import register from '../views/registerR.vue'
import userInfo from '../views/userInfo.vue'

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
  }, 
  {
    path: '/register',
    name: 'register',
    component: register
  },
  {
    path: '/userInfo/:id',
    name: 'userInfo',
    component: userInfo
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
