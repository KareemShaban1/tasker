import { createRouter, createWebHistory } from 'vue-router'
import { routes } from './routes'

async function isAuth() {
  const store = useStore()
  const toast = useToast()

  return await axiosIns
    .get('/api/user')
    .then(function (response) {
      store.commit('auth/SET_AUTHENTICATED', true)
      store.commit('auth/SET_USER', response.data)
      return true
    })
    .catch(e => {
      store.commit('auth/SET_AUTHENTICATED', false)
      store.commit('auth/SET_USER', null)
      console.log(e)
      if (e.response && e.response.status === 401) {
        console.log(e.response.status)
        toast.error(e.response.data.message)
      }

      return false
    })
}

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default function (app) {
  app.use(router)
}
export { router }
