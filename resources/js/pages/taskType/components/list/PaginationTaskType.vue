<template>
  <!-- Pagination Part -->
  <div
    v-if="taskTypesPaginatedData !== null"
    class="vertical-center mt-2 mb-5"
  >
    <div class="text-center">
      <VPagination
        v-model="query.page"
        class="pagination mb-2"
        :length="taskTypesPaginatedData.pagination.total_pages"
        @update:model-value="getResults"
      />
    </div>
  </div>
</template>

<script>
import { useStore } from 'vuex'
import { computed } from "vue"

export default {
  name: "PaginationTaskType",

  props: {
    query: {
      type: Object,
      required: true,
    },
  },

  setup(props) {
    const store = useStore()

    const taskTypesPaginatedData = computed(() => store.getters['TaskType/taskTypesPaginatedData'])
    const isLoading = computed(() => store.getters['TaskType/isLoading'])

    const getResults = () => {
      store.dispatch('TaskType/fetchAllTaskTypes', props.query)
    }

    return {
      getResults,
      taskTypesPaginatedData,
      isLoading,
    }
  },
}
</script>
