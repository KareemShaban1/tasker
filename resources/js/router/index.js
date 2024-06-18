import axiosIns from '@axios'
import NProgress from 'nprogress'
import { createRouter, createWebHistory } from 'vue-router'
import { useStore } from 'vuex'
import { useToast } from 'vue-toastification'

async function isAuth() {
  const store = useStore()
  const toast = useToast()

  return await axiosIns.get('/api/user').then(function (response) {
    store.commit('auth/SET_AUTHENTICATED', true)
    store.commit('auth/SET_USER', response.data)

    return true
  }).catch(e => {
    console.log(e)
    
    store.commit('auth/SET_AUTHENTICATED', false)
    store.commit('auth/SET_USER', null)
    if (e.response && e.response.status === 401) {
      console.log(e.response.status)
      toast.error(e.response.data.message)
    }

    return false
  })
}

/* Layouts */
const DashboardLayout = () =>
  import('../layouts/default.vue' /* webpackChunkName: "resource/js/components/layouts/dashboard" */)
/* Layouts */

const router = createRouter({
  history: createWebHistory('/'),
  routes: [
    { path: '/', redirect: '/login' },
    {
      path: '/',
      component: DashboardLayout,
      children: [
        {
          name: 'dashboard',
          path: 'dashboard',
          component: () => import('../pages/dashboard.vue'),
          meta: {},
        },
        {
          path: 'country',
          component: () => import('../pages/country/index.vue'),
          meta: { title: 'country' },
        },
        {
          path: 'city',
          component: () => import('../pages/city/index.vue'),
          meta: { title: 'city' },
        },
        {
          path: 'state',
          component: () => import('../pages/state/index.vue'),
          meta: { title: 'state' },
        },
        {
          path: 'language',
          component: () => import('../pages/language/index.vue'),
          meta: { title: 'language' },
        },
        {
          path: 'taskType',
          component: () => import('../pages/taskType/index.vue'),
          meta: { title: 'taskType' },
        },
        {
          path: 'category',
          component: () => import('../pages/category/index.vue'),
          meta: { title: 'category' },
        },
        {
          path: 'specialty',
          component: () => import('../pages/specialty/index.vue'),
          meta: { title: 'specialty' },
        },
        {
          path: 'client',
          component: () => import('../pages/client/index.vue'),
          meta: { title: 'client' },
        },
        {
          path: 'offer',
          component: () => import('../pages/offer/index.vue'),
          meta: { title: 'offer' },
        },
        {
          path: 'task',
          component: () => import('../pages/task/index.vue'),
          meta: { title: 'task' },
        },

        {
          path: '/logout',
          name: 'logout',
          meta: {
            middleware: "logout",
            title: `logout`,
          },
          beforeEnter: (to, from, next) => {
            localStorage.clear()
            sessionStorage.clear()
          },
        },
      ],
    },

    {
      path: '/logout',
      meta: {
        middleware: 'logout',
        title: `logout`,
      },
      beforeEnter: (to, from, next) => {
        // Clear localStorage
        localStorage.clear()

        sessionStorage.clear()
        console.log('loge out')

        // next("login")
      },
    },

    {
      path: '/',
      component: () => import('../layouts/blank.vue'),
      children: [
        {
          path: '/login',
          name: 'login',
          meta: {
            middleware: 'guest',
            title: `Login`,
          },
          component: () => import('../pages/login.vue'),
        },
        {
          path: '/register',
          meta: {
            middleware: 'guest',
            title: `Register`,
          },
          component: () => import('../pages/register.vue'),
        },

        // {
        //   path: '/:pathMatch(.*)*',
        //   meta: {
        //     middleware: 'guest',
        //     title: `any`,
        //   },
        //   component: () => import('../pages/[...all].vue'),
        // },
      ],
    },
  ],
})

async function handelRoute(to, from, next) {
  try {
    var Auth = await isAuth()
    if (to.fullPath === "/logout") {
      localStorage.clear()
      sessionStorage.clear()
      next({ name: "login" })
    } else {
      console.log("test")
      if (to.meta.middleware === "guest") {
        if (Auth === true) {
          next({ name: "dashboard" })
        } else {
          next()
        }
      } else {
        if (Auth === true) {
          next()
        } else {
          next({ name: "login" })
        }
      }
    }
  } catch (error) {
    console.error("Error checking authentication:", error)
    next(false) // Abort navigation in case of an error
  }
}

router.beforeEach(async (to, from, next) => {
  if (to.name) {
    // NProgress.start()
  }

  // document.title = `${to.meta.title} - ${import.meta.env.VITE_APP_NAME}`
  await handelRoute(to, from, next)
})

router.afterEach(() => {
  // Complete the animation of the route progress bar.
  NProgress.done()
})

export default router
