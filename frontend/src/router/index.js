import { createRouter, createWebHistory } from 'vue-router'
import { setTitle } from '@/router/guards/SetTitleGuard.mjs'
import { routes } from 'vue-router/auto-routes'

const API_BASE = 'http://backend.vm1.test/api'

let lastValidatedToken = null
let lastValidationResult = false

async function validateToken(token) {
  if (!token) return false

  if (token === lastValidatedToken) {
    return lastValidationResult
  }

  try {
    const response = await fetch(`${API_BASE}/me`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })

    lastValidatedToken = token
    lastValidationResult = response.ok

    return response.ok
  } catch (error) {
    lastValidatedToken = token
    lastValidationResult = false
    return false
  }
}

function clearSession() {
  localStorage.removeItem('token')
  localStorage.removeItem('userId')
}

export const router = createRouter({
  history: createWebHistory(),
  routes:[
    {
      path: '/',
      name: 'index',
      component: () => import('@/pages/index.vue'),
      meta: {
        title: 'Landing',
        public: true
      }
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/pages/login.vue'),
      meta: {
        title: 'Login',
        public: true
      }
    },
    {
      path: '/signup',
      name: 'signup',
      component: () => import('@/pages/signup.vue'),
      meta: {
        title: 'Sign Up',
        public: true
      }
    },
    {
      path: "/catalog",
      name: "catalogIndex",
      component: () => import("@/pages/catalog/index.vue"),
      meta: { title: 'Catalog Index' }
    },
    {
      path: "/catalog/:id",
      name: "Catalog",
      component: () => import("@/pages/catalog/[id].vue"),
      meta: { title: 'Catalog' }
    },
    {
      path: '/achievements',
      name: 'achievements',
      component: () => import('@/pages/achievements.vue'),
      meta: { title: 'My Achievements' }
    },
    {
      path: '/goals',
      name: 'Goals',
      component: () => import('@/pages/goals.vue'),
      meta: { title: 'Goals' }
    },
    {
      path: '/profile',
      name: 'profile',
      component: () => import('@/pages/profile.vue'),
      meta: { title: 'Profile' }
    },
    {
      path: '/logout',
      name: 'logout',
      component: () => import('@/pages/logout.vue'),
      meta: { title: 'Logout' }
    },
    {
      path: '/leaderboard',
      name: 'leaderboard',
      component: () => import('@/pages/leaderboard.vue'),
      meta: { title: 'Leaderboard' }
    },
    {
      path: "/users/:id",
      name: "userProfile",
      component: () => import("@/pages/userProfile.vue"),
      meta: { title: 'User Profile' }
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('@/pages/dashboard.vue'),
      meta: { title: 'Admin Dashboard' }
    } 
  ]
})

router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem('token')
  const hasToken = Boolean(token && token.trim())
  const isPublicRoute = to.meta.public === true

  if (isPublicRoute) {
    next()
    return
  }

  if (!hasToken) {
    next({ name: 'index' })
    return
  }

  const isValidToken = await validateToken(token)

  if (!isValidToken) {
    clearSession()
    next({ name: 'index' })
    return
  }

  next()
})


router.beforeEach(setTitle)
