<template>
  <VCol
    lg="12"
    class="d-flex justify-space-between align-start align-md-center flex-column flex-md-row"
  >
    <h1 class="w-100 text-capitalize">
      City
    </h1>
    <div class="FilterData w-100 justify-md-end justify-space-between flex-wrap d-flex align-start gap-2">
      <VBtn
        class="text-capitalize"
        @click="createCity"
      >
        Create City
      </VBtn>

      <ShowResult :query="query" />
      <FilterCity :query="query" />
    </div>
  </VCol>
</template>

<script>
import FilterCity from '@/pages/city/components/list/FilterCity.vue'
import ShowResult from '@/pages/city/components/list/ShowFilterResult.vue'
import { useStore } from 'vuex'

// import * as XLSX from 'xlsx'

export default {
  components: { FilterCity, ShowResult },
  props: {
    query: {
      type: Object,
      required: true,
    },
  },

  setup() {
    const store = useStore()

    const createCity = () => {
      store.commit('City/setIsCreating', true)
    }

    return {
      createCity,
    }
  },
}
</script>
