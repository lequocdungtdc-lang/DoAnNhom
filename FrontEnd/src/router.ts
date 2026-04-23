import { createRouter, createWebHistory } from 'vue-router'

const routes = [
   // 🔓 LOGIN
   {
      path: '/login',
      component: () => import('./pages/Login.vue'),
      meta: { layout: 'auth' }
   },

   // 👤 USER
   {
      path: '/',
      component: () => import('./pages/Home.vue'),
      meta: { requiresAuth: true, layout: 'user' }
   },

   {
      path: '/profile',
      component: () => import('./pages/Profile.vue'),
      meta: { requiresAuth: true, layout: 'user' }
   },

   // 👑 ADMIN (🔥 NESTED)
   {
      path: '/admin',
      meta: { requiresAuth: true, role: 'admin', layout: 'admin' },
      children: [
         {
            path: '',
            component: () => import('./pages/admin/Dashboard.vue')
         },
         {
            path: 'dashboard',
            component: () => import('./pages/admin/Dashboard.vue')
         },
         {
            path: 'settings',
            component: () => import('./pages/admin/Settings.vue')
         },
         {
            path: 'profile',
            component: () => import('./pages/Profile.vue') // nếu admin dùng chung
         }
      ]
   }
]

const router = createRouter({
   history: createWebHistory(),
   routes
})

// 🔥 GUARD
router.beforeEach((to, from, next) => {
   const token = localStorage.getItem('token')

   // 🔥 SAFE PARSE
   const userStr = localStorage.getItem('user')
   let user = null

   try {
      user = userStr ? JSON.parse(userStr) : null
   } catch {
      localStorage.removeItem('user')
      user = null
   }

   // ❌ chưa login
   if (to.meta.requiresAuth && !token) {
      return next('/login')
   }

   // 🔥 đã login mà vào login
   if (to.path === '/login' && token) {
      if (user?.role === 'admin') {
         return next('/admin')
      }
      return next('/')
   }

   // 🔥 check admin
   if (to.meta.role === 'admin') {
      if (!user || user.role !== 'admin') {
         return next({
            path: '/',
            query: { error: 'forbidden' }
         })
      }
   }

   next()
})

export default router