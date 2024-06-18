<template>
  <!-- Pagination Part -->
  <div
    v-if="paginatedData !== null"
    class="vertical-center mt-2 mb-5"
  >
    <div class="text-center">
      <VPagination
        v-model="query.page"
        class="pagination mb-2"
        :length="paginatedData.pagination.total_pages"
        @update:model-value="getResults"
      />
    </div>
  </div>
</template>

<script>
import { useStore } from "vuex"

export default {
  name: "PaginationComponent",

  props: {
    query: {
      type: Object,
      required: true,
    },
    store: {
      type: String,
      required: true,
    },
  },

  setup(props) {
    const store = useStore()
    const isLoading = computed( () => store.getters[props.store + '/isLoading'])
    const paginatedData = computed( () => store.getters[props.store + '/paginatedData'])

    const getResults = () => {
      store.dispatch(props.store + '/fetchAll', props.query)
    }

    return {
      isLoading,
      paginatedData,
      getResults,
    }
  },
}
</script>
