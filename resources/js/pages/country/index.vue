<template>
  <CountryIndex />

  <!-- Edit Dialog Part -->
  <EditCountry
    v-if="isUpdating"
    v-model="isUpdating"
  />

  <!-- Create Dialog Part -->
  <CreateCountry
    v-if="isCreating"
    v-model="isCreating"
  />
</template>

<script>
import CountryIndex from "@/pages/country/components/CountryIndex.vue"
import CreateCountry from "@/pages/country/components/create/CreateCountry.vue"
import EditCountry from "@/pages/country/components/edit/EditCountry.vue"

import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  components: { CountryIndex, CreateCountry, EditCountry },

  setup() {
    const store = useStore()
    const isCreating = computed(() => store.getters['Country/isCreating'])
    const isUpdating = computed(() => store.getters['Country/isUpdating'])

    return {
      isCreating,
      isUpdating,
    }
  },
}
</script>
