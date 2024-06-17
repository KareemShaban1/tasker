import axiosIns from "@/plugins/axios"
import router from "@/router"
import useHandler from "@/services/handler"

export default function useAuth(store) {
  const { generateUrl } = useHandler()

  const logout  = async (query = null) => {
    const res = await axiosIns.post('/api/logout', query).then(r => {
      store.commit('auth/SET_AUTHENTICATED', false)
      store.commit('auth/SET_USER', null)
      localStorage.removeItem('access_token')
      sessionStorage.removeItem('laravel_session')
      router.push('/login')
    }).catch(e => {
      console.log(e.response?.data || e.message)
    })
  }

  return {
    logout,
  }
}
