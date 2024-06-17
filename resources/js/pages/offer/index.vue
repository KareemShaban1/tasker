<template>
  <OfferIndex />

  <!-- Edit Dialog Part -->
  <EditOffer
    v-if="isUpdating"
    v-model="isUpdating"
  />

  <!-- Create Dialog Part -->
  <CreateOffer
    v-if="isCreating"
    v-model="isCreating"
  />
</template>

<script>
import OfferIndex from '@/pages/offer/components/OfferIndex.vue'
import CreateOffer from '@/pages/offer/components/create/CreateOffer.vue'
import EditOffer from '@/pages/offer/components/edit/EditOffer.vue'

import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  components: { OfferIndex, CreateOffer, EditOffer },

  setup() {
    const store = useStore()
    const isCreating = computed(() => store.getters['Offer/isCreating'])
    const isUpdating = computed(() => store.getters['Offer/isUpdating'])

    return {
      isCreating,
      isUpdating,
    }
  },
}
</script>
