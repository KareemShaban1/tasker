<template>
  <LanguageHeader :query="query" />
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
                  (languagesPaginatedData.pagination.current_page - 1) * languagesPaginatedData.pagination.per_page +
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

    <!-- <Pagination :query="query" /> -->
  </div>
</template>

<script>
import LanguageDetails from '@/pages/language/components/list/LanguageDetails.vue'
import LanguageHeader from '@/pages/language/components/list/LanguageHeader.vue'
import Pagination from '@/pages/language/components/list/PaginationLanguage.vue'
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'LanguageIndex',
  components: { LanguageDetails, LanguageHeader, Pagination },

  setup() {
    const store = useStore()

    const languages = computed(() => store.getters['Language/languagesList'])
    const languagesPaginatedData = computed(() => store.getters['Language/languagesPaginatedData'])
    const isLoading = computed(() => store.getters['Language/isLoading'])

    const fetchAll = () => {
      store.dispatch('Language/fetchAllLanguages', query)
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
      languagesPaginatedData,
      isLoading,
    }
  },
}
</script>
