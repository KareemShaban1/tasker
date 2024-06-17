<script setup>
import router from '@/router'
import axiosIns from '@axios'
import avatar1 from '@images/avatars/user-profile.png'
import { useStore } from 'vuex'
import useAuth from "@/services/Modules/Auth"

const userData = ref()
const isLoading = ref(true)
const store = useStore()
const { logout } = useAuth()

onMounted(async () => {
  userData.value = store.getters['auth/user']
  isLoading.value = false
})
</script>

<template>
  <div v-if="isLoading">
    <VProgressCircular
      :size="40"
      color="primary"
      indeterminate
    />
  </div>
  <VBadge
    v-else
    dot
    location="bottom right"
    offset-x="3"
    offset-y="3"
    color="success"
    bordered
  >
    <VAvatar
      class="cursor-pointer"
      color="primary"
      variant="tonal"
    >
      <VImg :src="avatar1" />

      <!-- SECTION Menu -->
      <VMenu
        activator="parent"
        width="230"
        location="bottom end"
        offset="14px"
      >
        <VList>
          <!-- 👉 User Avatar & Name -->
          <VListItem>
            <template #prepend>
              <VListItemAction start>
                <VBadge
                  dot
                  location="bottom right"
                  offset-x="3"
                  offset-y="3"
                  color="success"
                >
                  <VAvatar
                    color="primary"
                    variant="tonal"
                  >
                    <VImg :src="avatar1" />
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template>

            <VListItemTitle class="font-weight-semibold text-capitalize">
              {{ userData.name }}
            </VListItemTitle>
            <VListItemSubtitle v-if="userData.guide_id">
              {{ userData.guide ? userData.guide.name : '' }}
            </VListItemSubtitle>
          </VListItem>
          <VDivider class="my-2" />

          <!-- 👉 Profile -->
          <VListItem :to="`/user-profile/${userData.id}`">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="mdi-account-outline"
                size="22"
              />
            </template>

            <VListItemTitle>Profile</VListItemTitle>
          </VListItem>

          <!-- 👉 Settings -->
          <VListItem to="/account-settings">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="mdi-cog-outline"
                size="22"
              />
            </template>

            <VListItemTitle>Settings</VListItemTitle>
          </VListItem>

          <!-- Divider -->
          <VDivider class="my-2" />

          <!-- 👉 Logout -->
          <VListItem
            class="text-center"

            @click="logout"
          >
            <VBtn
              variant="flat"
              color="error"
              size="small"
            >
              <template #prepend>
                <VIcon
                  class="me-2"
                  icon="mdi-logout"
                  size="22"
                />
              </template>

              <VListItemTitle>Logout</VListItemTitle>
            </VBtn>
          </VListItem>
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VAvatar>
  </VBadge>
</template>
