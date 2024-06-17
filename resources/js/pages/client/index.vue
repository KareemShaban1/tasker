<template>
  <ClientIndex />

  <!-- Edit Dialog Part -->
  <EditClient
    v-if="isUpdating"
    v-model="isUpdating"
  />

  <!-- Create Dialog Part -->
  <CreateClient
    v-if="isCreating"
    v-model="isCreating"
  />
</template>

<script>
import ClientIndex from '@/pages/client/components/ClientIndex.vue'
import CreateClient from '@/pages/client/components/create/CreateClient.vue'
import EditClient from '@/pages/client/components/edit/EditClient.vue'

import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  components: { ClientIndex, CreateClient, EditClient },

  setup() {
    const store = useStore()
    const isCreating = computed(() => store.getters['Client/isCreating'])
    const isUpdating = computed(() => store.getters['Client/isUpdating'])

    return {
      isCreating,
      isUpdating,
    }
  },
}
</script>
