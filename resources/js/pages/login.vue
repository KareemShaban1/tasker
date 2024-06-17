<script setup>
import router from '@/router'
import axiosIns from '@axios'
import { computed, ref } from 'vue'
import { useToast } from 'vue-toastification'
import 'vue-toastification/dist/index.css'
import { useTheme } from 'vuetify'
import { useStore } from 'vuex'

import banner from '@images/auth/login-page.png'
import footerBannerImg from '@images/auth/footer-banner-login.png'
import footerImg from '@images/auth/footer-login.png'

const store = useStore()
const toast = useToast()
const isLoading = ref(false)

const form = ref({
  email: '',
  password: '',
})

const vuetifyTheme = useTheme()

const authThemeMask = computed(() => {
  return vuetifyTheme.global.name.value === 'light' ? authV1MaskLight : authV1MaskDark
})

const isPasswordVisible = ref(false)

const login = () => {
  isLoading.value = true

  axiosIns.post('/api/auth/login', {
    email: form.value.email,
    password: form.value.password,
  })
    .then(response => {
      console.log('response >>>', response.data)
      store.commit('auth/SET_AUTHENTICATED', true)
      store.commit('auth/SET_USER', response.data.user)

      const { message, accessToken } = response.data

      localStorage.setItem('accessToken', JSON.stringify(accessToken))
      router.push('/dashboard')
    })
    .catch(error => {
      console.error(error)
      toast.warning(error.response.data.message, { timeout: 2500 })
    })
    .finally(() => {
      isLoading.value = false
    })
}
</script>


<template> 
  <VRow class="auth-wrapper">
    <VCol
      cols="12"
      md="8"
      class="d-none d-md-flex position-relative"
    >
      <div class="d-flex align-center justify-end w-100 h-100 pa-10 pe-0">
        <VResponsive
          class="auth-illustration"
          :style="{ maxWidth: '797px' }"
        >
          <img
            class="w-100 h-100"
            style="object-fit: cover;"
            :src="banner"
            alt="Illustration"
          >
        </VResponsive>
      </div>
      <img
        class="layout-blank auth-footer-mask"
        height="360"
        :src="footerBannerImg"
        alt="Footer Mask"
      >
      <VResponsive
        class="layout-blank auth-footer-tree"
        img="footerImg"
        style="height: 190px; width: 90px;"
      >
        <VImg
          :src="footerImg"
          alt="tree image"
          style=""
        />
      </VResponsive>
    </VCol>
    <VCol
      cols="12"
      md="4"
      class="auth-card-v2 d-flex align-center justify-center position-relative"
      style="background-color: rgb(var(--v-theme-surface));"
    >
      <div
        v-if="isLoading"
        class="loading-page"
      >
        <VProgressCircular
          :size="50"
          indeterminate
          color="primary"
        />
      </div>
      <VCard
        v-else
        class="pa-4"
        style="max-width: 500px;"
      >
        <div class="d-block d-md-none">
          <VResponsive
            class="auth-illustration"
            :style="{ maxWidth: '500px' }"
          >
            <img
              class="w-100 h-100"
              style="object-fit: cover;"
              :src="banner"
              alt="Illustration"
            >
          </VResponsive>
        </div>
        <VCardText>
          <h4 class="text-h4 mb-1">
            Welcome to <span class="text-uppercase">crm!</span> 👋🏻
          </h4>
          <p class="mb-0">
            Please sign-in to your account and start the adventure
          </p>
        </VCardText>

        <VCardText>
          <VForm @submit.prevent="() => {}">
            <VRow>
              <VCol cols="12">
                <VTextField
                  v-model="form.email"
                  label="Email"
                  type="email"
                />
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="form.password"
                  label="Password"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'mdi-eye-outline' : 'mdi-eye-off-outline'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />
              </VCol>
            </VRow>

            <VBtn
              type="submit"
              :disabled="processing"
              class="mt-4"
              color="primary"
              block
              @click="login"
            >
              Login
            </VBtn>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<style scoped>
.auth-wrapper {
  min-block-size: 100dvh;
  margin: 0;
}

.auth-illustration {
  max-width: 797px;
}

.auth-card-v2 {
  background-color: rgb(var(--v-theme-surface));
}
.layout-blank .auth-footer-tree {
  position: absolute !important;
  inset-inline-start: 70px;
  inset-block-end: 70px;
}
.layout-blank .auth-footer-mask {
  position: absolute;
    inset-block-end: 0;
    max-inline-size: 100%;
    min-inline-size: 100%;
}
</style>
