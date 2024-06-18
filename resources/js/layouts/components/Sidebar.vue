<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue'

import VerticalNavLayout from '@layouts/components/VerticalNavLayout.vue'
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue'
import { ref } from 'vue'
import { useTheme } from 'vuetify'
import { useStore } from 'vuex'

// Components
import Footer from '@/layouts/components/Footer.vue'

// import NavBarNotifications from '@/layouts/components/NavBarNotifications.vue'
import NavbarThemeSwitcher from '@/layouts/components/NavbarThemeSwitcher.vue'
import UserProfile from '@/layouts/components/UserProfile.vue'

const vuetifyTheme = useTheme()

// put the max array of navs Groups is 10000 if you have more then icrease the number
const numberOfNavGroups = 10000
const isOpen = ref(new Array(numberOfNavGroups).fill(false))
const toggles = ref(Array.from({ length: numberOfNavGroups.value }, (_, index) => index + 1))

const store = useStore()

// const user = store.getters['auth/user']

const toggleOpen = index => {
  isOpen.value = isOpen.value.map((state, i) => (i === index ? !state : false))
}

// // Function to check if the user has a specific permission
// const hasPermission = permission => {
//   return user && user.permissions.includes(permission)
// }

// const hasAnyPermission = permissions => {
//   if (!permissions || permissions.length === 0) {
//     // If no permissions are specified, return true
//     return true
//   }

//   // Check if the user has any of the required permissions
//   return permissions.some(permission => user && user.permissions.includes(permission))
// }

function handleChildClick(event) {
  event.stopPropagation()
}

function handleOutsideClick(event) {
  const isLinkOrChild = event.target.closest('a') !== null

  // Check if the click occurred outside the nav-group and is not a link or its descendant
  if (isLinkOrChild && !toggles.value.includes(event.target)) {
    // Check if the closest 'a' ancestor has the specified class
    const inLinkClass = event.target.closest('a').classList.contains('router-link-active')

    // Check if the closest 'a' ancestor does not have the specified class
    if (!inLinkClass) {
      isOpen.value = isOpen.value.map(() => false)
    }
  }
}

function computeDynamicIndex(arrayKey, index) {
  // Summing up the lengths of arrays preceding the current array
  let totalLength = 0
  for (const key in navItems) {
    if (Object.prototype.hasOwnProperty.call(navItems, key)) {
      if (key === arrayKey) break // Stop when reaching the current array
      totalLength += navItems[key].length
    }
  }

  return index + totalLength + 1
}
onMounted(() => {
  document.addEventListener('click', handleOutsideClick)

  // numberOfNavGroups.value=document.querySelectorAll(".nav-group").length
  // isOpen.value = new Array(numberOfNavGroups.value).fill(false)

  // toggles.value=Array.from({ length: numberOfNavGroups }, (_, index) => index + 1)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleOutsideClick)
})

const navItems = {
  dashboard: [
    {
      title: 'Country',
      icon: 'ri-earth-line',
      to: '/country',

      // permissions: ['access-dashboard'],
    },
    {
      title: 'City',
      icon: 'ri-earth-line',
      to: '/city',

      // permissions: ['access-dashboard'],
    },
    {
      title: 'state',
      icon: 'ri-earth-line',
      to: '/state',

      // permissions: ['access-dashboard'],
    },
    {
      title: 'language',
      icon: 'ri-translate-2',
      to: '/language',

      // permissions: ['access-dashboard'],
    },
    {
      title: 'taskType',
      icon: 'ri-task-line',
      to: '/taskType',

      // permissions: ['access-dashboard'],
    },
    {
      title: 'category',
      icon: 'ri-task-line',
      to: '/category',

      // permissions: ['access-dashboard'],
    },
    {
      title: 'specialty',
      icon: 'ri-task-line',
      to: '/specialty',

      // permissions: ['access-dashboard'],
    },

    {
      title: 'clients',
      icon: 'ri-task-line',
      to: '/client',

      // permissions: ['access-dashboard'],
    },
    {
      title: 'offers',
      icon: 'ri-task-line',
      to: '/offer',

      // permissions: ['access-dashboard'],
    },

    {
      title: 'tasks',
      icon: 'ri-task-line',
      to: '/task',

      // permissions: ['access-dashboard'],
    },
  ],
}
</script>

<template>
  <VerticalNavLayout>
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center">
        <!-- 👉 Vertical nav toggle in overlay mode -->
        <IconBtn
          class="ms-n3"
          @click="toggleVerticalOverlayNavActive(true)"
        >
          <VIcon icon="mdi-menu" />
        </IconBtn>

        <div
          class="d-flex align-center cursor-pointer"
          style="user-select: none"
        />

        <VSpacer />

        <NavbarThemeSwitcher class="me-2" />

        <NavBarNotifications class="me-2" />
        <UserProfile class="me-2" />
      </div>
    </template>

    <template #vertical-nav-content>
      <VerticalNavSectionTitle
        :item="{
          heading: 'dashboard',
        }"
      />
      <template
        v-for="(item, index) in navItems.dashboard"
        :key="computeDynamicIndex('dashboard', index)"
      >
        <template v-if="item.children">
          <li
            :ref="'toggle' + computeDynamicIndex('dashboard', index)"
            class="my-1 nav-group"
            :class="{
              active: isOpen[computeDynamicIndex('dashboard', index)],
              open: isOpen[computeDynamicIndex('dashboard', index)],
            }"
            @click="toggleOpen(computeDynamicIndex('dashboard', index))"
          >
            <div class="nav-group-label d-flex align-center">
              <VIcon
                :icon="item.icon"
                class="nav-item-icon"
              />
              <span class="nav-item-title text-capitalize">{{ item.title }}</span>
              <VIcon
                icon="mdi-chevron-right"
                class="nav-group-arrow"
              />
            </div>

            <ul
              v-show="isOpen[computeDynamicIndex('dashboard', index)]"
              class="nav-group-children"
            >
              <template v-for="(childItem, childIndex) in item.children">
                <template v-if="hasAnyPermission(childItem.permissions)">
                  <VerticalNavLink
                    :key="childIndex"
                    class="text-capitalize"
                    :item="childItem"
                    @click="handleChildClick"
                  />
                </template>
              </template>
            </ul>
          </li>
        </template>
        <VerticalNavLink
          v-else
          :item="{
            title: item.title,
            icon: item.icon,
            to: item.to,
          }"
          class="text-capitalize"
        />
      </template>
    </template>

    <!-- 👉 Pages -->
    <slot />

    <!-- 👉 Footer -->
    <template #footer>
      <Footer />
    </template>
  </VerticalNavLayout>
</template>

<style lang="scss" scoped>
.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 6px;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}
</style>

<style lang="scss">
.bg-odd {
  /* stylelint-disable-next-line max-line-length */
  background: linear-gradient(
    72.47deg,
    rgb(var(--v-theme-primary), 0.75) 22.16%,
    rgba(var(--v-theme-primary), 0.5) 76.47%
  );
  color: white;
}

.error-ql-container {
  border: 1px solid red;
}

.ql-container {
  /* stylelint-disable-next-line liberty/use-logical-spec */
  width: 100% !important;
  /* stylelint-disable-next-line liberty/use-logical-spec */
  height: 150px;
}

.editor-container {
  position: relative;
  overflow: hidden;
}

.resizer {
  position: absolute;
  /* stylelint-disable-next-line liberty/use-logical-spec */
  right: 0;
  /* stylelint-disable-next-line liberty/use-logical-spec */
  bottom: 0;
  /* stylelint-disable-next-line liberty/use-logical-spec */
  width: 10px;
  /* stylelint-disable-next-line liberty/use-logical-spec */
  height: 10px;
  background-color: rgb(var(--v-theme-primary));
  cursor: se-resize;
}

.ql-snow .ql-stroke {
  stroke: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity)) !important;
}

.ql-snow * {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

.loading-page {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.ul-editorPadding ul,
.ul-editorPadding ol {
  /* stylelint-disable-next-line liberty/use-logical-spec */
  padding-left: 30px;
}

.drawerFilter .v-card__underlay {
  display: none;
}

.FilterData .v-expansion-panel--active > .v-expansion-panel-title {
  width: 350px;
}

@media (max-width: 767px) {
  .FilterData .v-expansion-panel--active > .v-expansion-panel-title {
    width: 280px;
  }
}

.FilterData .v-expansion-panel-title {
  min-height: 39px !important;
  padding: 5px 20px !important;
}

.drawerFilter .v-card {
  overflow: auto;
}
</style>
