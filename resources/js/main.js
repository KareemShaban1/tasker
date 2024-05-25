import { createApp } from 'vue'
import '@/@iconify/icons-bundle'
import App from '@/App.vue'

// Styles
import '@core-scss/template/index.scss'
import '@layouts/styles/index.scss'
import Toast from 'vue-toastification'
import Vuex from 'vuex'
import 'vuetify/styles'
import 'maz-ui/styles'
import router from '@/router'
import store from './store'
import vuetify from '@/plugins/vuetify'
import 'remixicon/fonts/remixicon.css'

// Create vue app
const app = createApp(App)

app.use(Vuex)
app.use(vuetify)
app.use(router)
app.use(store)
app.use(Toast, {
  transition: 'Vue-Toastification__bounce',
  maxToasts: 5,
  newestOnTop: true,
  timeout: 1000,
})

// Mount vue app
app.mount('#app')
