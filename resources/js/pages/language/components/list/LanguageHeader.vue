<template>
  <VCol
    lg="12"
    class="d-flex justify-space-between align-start align-md-center flex-column flex-md-row"
  >
    <h1 class="w-100 text-capitalize">Language</h1>
    <div class="FilterData w-100 justify-md-end justify-space-between flex-wrap d-flex align-start gap-2">
      <VBtn
        class="text-capitalize"
        @click="createLanguage"
      >
        Create Language
      </VBtn>

      <ShowResult :query="query" />
      <FilterLanguage :query="query" />
    </div>
  </VCol>
</template>

<script>
import FilterLanguage from '@/pages/language/components/list/FilterLanguage.vue'
import ShowResult from '@/pages/language/components/list/ShowFilterResult.vue'
import { useStore } from 'vuex'

// import * as XLSX from 'xlsx'

export default {
  components: { FilterLanguage, ShowResult },
  props: {
    query: {
      type: Object,
      required: true,
    },
  },

  setup() {
    const store = useStore()

    const createLanguage = () => {
      store.commit('Language/setIsCreating', true)
    }

    return {
      createLanguage,
    }
  },
}
</script>
