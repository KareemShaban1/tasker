import axios from 'axios'

import NProgress from 'nprogress'

const accessToken = localStorage.getItem('accessToken') ?? ''

const axiosIns = axios.create({
  baseURL: 'http://127.0.0.1:8000/',

  /*
  this live server
 */

  // baseURL: 'https://tasker.kareemsoft.online/',

  withCredentials: true,

  headers: {
    Authorization: `Bearer ${accessToken}`,
  },
})

// before a request is made start the nprogress
axiosIns.interceptors.request.use(config => {
  NProgress.start()

  return config
})

// before a response is returned stop nprogress
axiosIns.interceptors.response.use(response => {
  NProgress.done()

  return response
})

// axiosIns.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

export default axiosIns
