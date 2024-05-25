<template>
  <!-- Pagination Part -->
  <div
    v-if="languagesPaginatedData !== null"
    class="vertical-center mt-2 mb-5"
  >
    <div class="text-center">
      <VPagination
        v-model="query.page"
        class="pagination mb-2"
        :length="languagesPaginatedData.pagination.total_pages"
        @update:model-value="getResults"
      />
    </div>
  </div>
</template>

<script>
import { useStore } from 'vuex'
import { computed } from "vue"

export default {
  name: "PaginationLanguage",

  props: {
    query: {
      type: Object,
      required: true,
    },
  },

  setup(props) {
    const store = useStore()

    const languagesPaginatedData = computed(() => store.getters['Language/languagesPaginatedData'])
    const isLoading = computed(() => store.getters['Language/isLoading'])

    const getResults = () => {
      store.dispatch('Language/fetchAllLanguages', props.query)
    }

    return {
      getResults,
      languagesPaginatedData,
      isLoading,
    }
  },
}
</script>
