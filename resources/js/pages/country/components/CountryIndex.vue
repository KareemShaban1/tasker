<template>
  <CountryHeader :query="query" />
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
              v-for="(country,index) in countries"
              :key="country.id"
            >
              <CountryDetails
                :index="(countriesPaginatedData.pagination.current_page - 1) * countriesPaginatedData.pagination.per_page + index + 1"
                :country="country"
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
import CountryDetails from "@/pages/country/components/list/CountryDetails.vue"
import CountryHeader from "@/pages/country/components/list/CountryHeader.vue"
import Pagination from "@/pages/country/components/list/PaginationCountry.vue"
import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  name: 'CountryIndex',
  components: { CountryDetails, CountryHeader, Pagination },

  setup() {
    const store = useStore()

    const countries = computed(() => store.getters['Country/countriesList'])
    const countriesPaginatedData = computed(() => store.getters['Country/countriesPaginatedData'])
    const isLoading = computed(() => store.getters['Country/isLoading'])

    const fetchAll = () => {
      store.dispatch('Country/fetchAllCountries', query)
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
      countries,
      countriesPaginatedData,
      isLoading,
    }
  },
}
</script>
