<template>
  <VCol
    lg="12"
    class="d-flex justify-space-between align-start align-md-center flex-column flex-md-row"
  >
    <h1 class="w-100 text-capitalize">
      TaskType
    </h1>
    <div class="FilterData w-100 justify-md-end justify-space-between flex-wrap d-flex align-start gap-2">
      <VBtn
        class="text-capitalize"
        @click="createTaskType"
      >
        Create TaskType
      </VBtn>

      <ShowResult :query="query" />
      <FilterTaskType :query="query" />
    </div>
  </VCol>
</template>

<script>
import FilterTaskType from '@/pages/taskType/components/list/FilterTaskType.vue'
import ShowResult from '@/pages/taskType/components/list/ShowFilterResult.vue'
import { useStore } from 'vuex'

// import * as XLSX from 'xlsx'

export default {
  components: { FilterTaskType, ShowResult },
  props: {
    query: {
      type: Object,
      required: true,
    },
  },

  setup() {
    const store = useStore()

    const createTaskType = () => {
      store.commit('TaskType/setIsCreating', true)
    }

    return {
      createTaskType,
    }
  },
}
</script>
