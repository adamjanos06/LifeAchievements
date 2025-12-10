import { createRouter, createWebHistory } from 'vue-router'
import { setTitle } from '@/router/guards/SetTitleGuard.mjs'
import { routes } from 'vue-router/auto-routes'

export const router = createRouter({
  history: createWebHistory(),
  routes:[
    {
      path: '/',
      name: 'index',
      component: () => import('@/pages/index.vue'),
      meta: {
        title: 'Landing'
      }
    },
    {
      path: '/introduction',
      name: 'introduction',
      component: () => import('@/pages/introduction.vue'),
      meta: {
        title: 'Introduction'
      }
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/pages/login.vue'),
      meta: { title: 'Login' }
    },
    {
      path: '/signup',
      name: 'signup',
      component: () => import('@/pages/signup.vue'),
      meta: { title: 'Sign Up' }
    }
  ]
})


router.beforeEach(setTitle)
