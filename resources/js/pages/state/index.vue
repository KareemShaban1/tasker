<template>
  <StateIndex />

  <!-- Edit Dialog Part -->
  <EditState
    v-if="isUpdating"
    v-model="isUpdating"
  />

  <!-- Create Dialog Part -->
  <CreateState
    v-if="isCreating"
    v-model="isCreating"
  />
</template>

<script>
import StateIndex from '@/pages/state/components/StateIndex.vue'
import CreateState from '@/pages/state/components/create/CreateState.vue'
import EditState from '@/pages/state/components/edit/EditState.vue'

import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  components: { StateIndex, CreateState, EditState },

  setup() {
    const store = useStore()
    const isCreating = computed(() => store.getters['State/isCreating'])
    const isUpdating = computed(() => store.getters['State/isUpdating'])

    return {
      isCreating,
      isUpdating,
    }
  },
}
</script>
