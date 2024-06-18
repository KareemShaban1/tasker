<template>
  <Header
  title="Language"
  create-component
  create-title="Create new language"
  store="Language"
  :query="query"
  :selected-ids="selectedIds"
  @clear-selected="updateSelectedIds"
/>   
<div>
    <VCard>
      <VCardText>
        <VTable>
          <thead>
            <tr>
              <th class="text-capitalize">
                #
              </th>
              <th class="text-capitalize">
                Name
              </th>
              <th class="text-capitalize">
                created at
              </th>
              <th class="text-capitalize text-center">
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(language, index) in languages"
              :key="language.id"
            >
              <LanguageDetails
                :index="
                  (paginatedData.pagination.current_page - 1) * paginatedData.pagination.per_page +
                    index +
                    1
                "
                :language="language"
                :query="query"
              />
            </tr>
            <div
              v-if="isLoading"
              class="loading-page"
            >
              <VProgressCircular
                :per_page="50"
                color="primary"
                indeterminate
              />
            </div>
          </tbody>
        </VTable>
      </VCardText>
    </VCard>

    <PaginationComponent :query="query" store="Language" />
  </div>
</template>

<script>
import LanguageDetails from '@/pages/language/components/list/LanguageDetails.vue'
import PaginationComponent from '@/components/PaginationComponent.vue'
import Header from "@/components/Header.vue"
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'LanguageIndex',
  components: { LanguageDetails, Header, PaginationComponent },

  setup() {
    const store = useStore()

    const languages = computed(() => store.getters['Language/languagesList'])
    const paginatedData = computed(() => store.getters['Language/paginatedData'])
    const isLoading = computed(() => store.getters['Language/isLoading'])

    const fetchAll = () => {
      store.dispatch('Language/fetchAll', query)
    }

    onMounted(() => {
      fetchAll()
    })

    const query = reactive({
      page: 1,
      per_page: 10,
      name: '',
      paginate: true,
      full_data: true,
      with_trashed: true,
    })

    return {
      query,
      languages,
      paginatedData,
      isLoading,
    }
  },
}
</script>
