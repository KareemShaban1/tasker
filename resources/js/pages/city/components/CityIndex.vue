<template>
  <Header
  title="City"
  create-component
  create-title="Create new city"
  store="City"
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
                :index="(paginatedData.pagination.current_page - 1) * paginatedData.pagination.per_page + index + 1"
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

    <PaginationComponent :query="query" store="City" />
  </div>
</template>

<script>
import CityDetails from "@/pages/city/components/list/CityDetails.vue"
import PaginationComponent from '@/components/PaginationComponent.vue'
import Header from "@/components/Header.vue"
import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  name: 'CityIndex',
  components: { CityDetails, Header, PaginationComponent },

  setup() {
    const store = useStore()

    const cities = computed(() => store.getters['City/citiesList'])
    const paginatedData = computed(() => store.getters['City/paginatedData'])
    const isLoading = computed(() => store.getters['City/isLoading'])

    const fetchAll = () => {
      store.dispatch('City/fetchAll', query)
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
      paginatedData,
      isLoading,
    }
  },
}
</script>
