<template>
  <SpecialtyIndex />

  <!-- Edit Dialog Part -->
  <EditSpecialty
    v-if="isUpdating"
    v-model="isUpdating"
  />

  <!-- Create Dialog Part -->
  <CreateSpecialty
    v-if="isCreating"
    v-model="isCreating"
  />
</template>

<script>
import SpecialtyIndex from "@/pages/specialty/components/SpecialtyIndex.vue"
import CreateSpecialty from "@/pages/specialty/components/create/CreateSpecialty.vue"
import EditSpecialty from "@/pages/specialty/components/edit/EditSpecialty.vue"

import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  components: { SpecialtyIndex, CreateSpecialty, EditSpecialty },

  setup() {
    const store = useStore()
    const isCreating = computed(() => store.getters['Specialty/isCreating'])
    const isUpdating = computed(() => store.getters['Specialty/isUpdating'])

    return {
      isCreating,
      isUpdating,
    }
  },
}
</script>
