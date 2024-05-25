import axiosIns from '@axios'
import NProgress from 'nprogress'
import { createRouter, createWebHistory } from 'vue-router'
import { useStore } from 'vuex'
import { useToast } from 'vue-toastification'

async function isAuth() {
  const store = useStore()
  const toast = useToast()

  // return await axiosIns
  //   .get('/api/user')
  //   .then(function (response) {
  //     store.commit('auth/SET_AUTHENTICATED', true)
  //     store.commit('auth/SET_USER', response.data)
  //     return true
  //   })
  //   .catch(e => {
  //     store.commit('auth/SET_AUTHENTICATED', false)
  //     store.commit('auth/SET_USER', null)
  //     console.log(e)
  //     if (e.response && e.response.status === 401) {
  //       console.log(e.response.status)
  //       toast.error(e.response.data.message)
  //     }

  //     return false
  //   })
  return true
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

    if (to.fullPath == '/logout') {
      // Clear localStorage
      localStorage.clear()

      // Clear sessionStorage
      sessionStorage.clear()
      console.log('loge out')
      next({ name: 'login' })
    } else {
      if (to.meta.middleware == 'guest') {
        if (Auth === true) {
          next({ name: 'dashboard' })
        } else {
          next()
        }
      } else {
        if (Auth === true) {
          // if (await hasPermission(to.meta.permissions) === true) { // Corrected here
          //   console.log('test 1')
          //   next()
          // } else {
          //   console.log('test 2')
          //   next({ name: "dashboard" })
          // }

          next()
        } else {
          next({ name: 'login' })
        }
      }
    }
  } catch (error) {
    console.error('Error checking authentication:', error)
    next(false) // Abort navigation in case of an error
  }
}

router.beforeEach(async (to, from, next) => {
  if (to.name) {
    // Start the route progress bar.
    NProgress.start()
  }

  document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`

  await handelRoute(to, from, next)
})

router.afterEach(() => {
  // Complete the animation of the route progress bar.
  NProgress.done()
})

export default router
