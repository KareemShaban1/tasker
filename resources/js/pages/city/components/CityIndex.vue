<template>
  <CityHeader :query="query" />
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
                Country
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
              v-for="(city,index) in cities"
              :key="city.id"
            >
              <CityDetails
                :index="(citiesPaginatedData.pagination.current_page - 1) * citiesPaginatedData.pagination.per_page + index + 1"
                :city="city"
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
import CityDetails from "@/pages/city/components/list/CityDetails.vue"
import CityHeader from "@/pages/city/components/list/CityHeader.vue"
import Pagination from "@/pages/city/components/list/PaginationCity.vue"
import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  name: 'CityIndex',
  components: { CityDetails, CityHeader, Pagination },

  setup() {
    const store = useStore()

    const cities = computed(() => store.getters['City/citiesList'])
    const citiesPaginatedData = computed(() => store.getters['City/citiesPaginatedData'])
    const isLoading = computed(() => store.getters['City/isLoading'])

    const fetchAll = () => {
      store.dispatch('City/fetchAllCities', query)
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
      cities,
      citiesPaginatedData,
      isLoading,
    }
  },
}
</script>
