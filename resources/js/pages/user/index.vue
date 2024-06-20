<template>
  <UserIndex />

  <!-- Edit Dialog Part -->
  <EditUser
    v-if="isUpdating"
    v-model="isUpdating"
  />

  <!-- Create Dialog Part -->
  <CreateUser
    v-if="isCreating"
    v-model="isCreating"
  />
</template>

<script>
import UserIndex from '@/pages/user/components/UserIndex.vue'
import CreateUser from '@/pages/user/components/create/CreateUser.vue'
import EditUser from '@/pages/user/components/edit/EditUser.vue'

import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  components: { UserIndex, CreateUser, EditUser },

  setup() {
    const store = useStore()
    const isCreating = computed(() => store.getters['User/isCreating'])
    const isUpdating = computed(() => store.getters['User/isUpdating'])

    return {
      isCreating,
      isUpdating,
    }
  },
}
</script>
