<template>
  <VCol
    lg="12"
    class="d-flex justify-space-between align-start align-md-center flex-column flex-md-row"
  >
    <h1 class="w-100 text-capitalize">
      State
    </h1>
    <div class="FilterData w-100 justify-md-end justify-space-between flex-wrap d-flex align-start gap-2">
      <VBtn
        class="text-capitalize"
        @click="createState"
      >
        Create State
      </VBtn>

      <ShowResult :query="query" />
      <FilterState :query="query" />
    </div>
  </VCol>
</template>

<script>
import FilterState from '@/pages/state/components/list/FilterState.vue'
import ShowResult from '@/pages/state/components/list/ShowFilterResult.vue'
import { useStore } from 'vuex'

// import * as XLSX from 'xlsx'

export default {
  components: { FilterState, ShowResult },
  props: {
    query: {
      type: Object,
      required: true,
    },
  },

  setup() {
    const store = useStore()

    const createState = () => {
      store.commit('State/setIsCreating', true)
    }

    return {
      createState,
    }
  },
}
</script>
