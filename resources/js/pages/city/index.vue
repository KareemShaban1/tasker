<template>
  <CityIndex />

  <!-- Edit Dialog Part -->
  <EditCity
    v-if="isUpdating"
    v-model="isUpdating"
  />

  <!-- Create Dialog Part -->
  <CreateCity
    v-if="isCreating"
    v-model="isCreating"
  />
</template>

<script>
import CityIndex from '@/pages/city/components/CityIndex.vue'
import CreateCity from '@/pages/city/components/create/CreateCity.vue'
import EditCity from '@/pages/city/components/edit/EditCity.vue'

import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  components: { CityIndex, CreateCity, EditCity },

  setup() {
    const store = useStore()
    const isCreating = computed(() => store.getters['City/isCreating'])
    const isUpdating = computed(() => store.getters['City/isUpdating'])

    return {
      isCreating,
      isUpdating,
    }
  },
}
</script>
