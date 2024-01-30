import { createRouter, createWebHistory } from 'vue-router'
import { loadLayoutMiddleware } from "@/middleware/layoutLoader";
import {AppLayoutsEnum} from "@/layouts/layouts.types";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../views/index.vue'),
      meta: {
        auth: true
      },
    },
    {
      path: '/management',
      name: 'management',
      component: () => import('../views/management/index.vue'),
      meta: {
        navBar: true,
        auth: true
      },
    },
    {
      path: '/clients',
      name: 'clients',
      component: () => import('../views/clients/index.vue'),
      meta: {
        navBar: true,
        auth: true
      },
    },
    {
      path: '/bills',
      name: 'bills',
      component: () => import('../views/bills/index.vue'),
      meta: {
        navBar: true,
        auth: true
      },
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/login/index.vue'),
      meta: {
        layout: AppLayoutsEnum.login,
      }
    },

  ]
})

router.beforeEach(loadLayoutMiddleware);
router.beforeEach((to, from, next)=>{
  if(!localStorage.getItem('login') && to.meta.auth) next('/login')
  else next()
})


export default router
