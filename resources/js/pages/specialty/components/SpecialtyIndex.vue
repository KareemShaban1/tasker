<template>
  <Header
  title="Specialty"
  create-component
  create-title="Create new specialty"
  store="Specialty"
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
              v-for="(specialty,index) in specialties"
              :key="specialty.id"
            >
              <SpecialtyDetails
                :index="(specialtiesPaginatedData.pagination.current_page - 1) * specialtiesPaginatedData.pagination.per_page + index + 1"
                :specialty="specialty"
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
import SpecialtyDetails from "@/pages/specialty/components/list/SpecialtyDetails.vue"
import Header from "@/components/Header.vue"
import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  name: 'SpecialtyIndex',
  components: { SpecialtyDetails, Header },

  setup() {
    const store = useStore()

    const specialties = computed(() => store.getters['Specialty/specialtiesList'])
    const specialtiesPaginatedData = computed(() => store.getters['Specialty/specialtiesPaginatedData'])
    const isLoading = computed(() => store.getters['Specialty/isLoading'])

    const fetchAll = () => {
      store.dispatch('Specialty/fetchAll', query)
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
      specialties,
      specialtiesPaginatedData,
      isLoading,
    }
  },
}
</script>
