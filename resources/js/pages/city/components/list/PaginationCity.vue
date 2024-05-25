<template>
  <!-- Pagination Part -->
  <div
    v-if="countriesPaginatedData !== null"
    class="vertical-center mt-2 mb-5"
  >
    <div class="text-center">
      <VPagination
        v-model="query.page"
        class="pagination mb-2"
        :length="countriesPaginatedData.pagination.total_pages"
        @update:model-value="getResults"
      />
    </div>
  </div>
</template>

<script>
import { useStore } from 'vuex'
import { computed } from "vue"

export default {
  name: "PaginationCountry",

  props: {
    query: {
      type: Object,
      required: true,
    },
  },

  setup(props) {
    const store = useStore()

    const countriesPaginatedData = computed(() => store.getters['City/countriesPaginatedData'])
    const isLoading = computed(() => store.getters['City/isLoading'])

    const getResults = () => {
      store.dispatch('City/fetchAllCities', props.query)
    }

    return {
      getResults,
      countriesPaginatedData,
      isLoading,
    }
  },
}
</script>
