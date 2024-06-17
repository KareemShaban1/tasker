<template>
  <Header
  title="State"
  create-component
  create-title="Create new state"
  store="State"
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
                City
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
              v-for="(state,index) in states"
              :key="state.id"
            >
              <StateDetails
                :index="(statesPaginatedData.pagination.current_page - 1) * statesPaginatedData.pagination.per_page + index + 1"
                :state="state"
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
import StateDetails from "@/pages/state/components/list/StateDetails.vue"
import Header from "@/components/Header.vue"
import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  name: 'StateIndex',
  components: { StateDetails, Header },

  setup() {
    const store = useStore()

    const states = computed(() => store.getters['State/statesList'])
    const statesPaginatedData = computed(() => store.getters['State/statesPaginatedData'])
    const isLoading = computed(() => store.getters['State/isLoading'])

    const fetchAll = () => {
      store.dispatch('State/fetchAll', query)
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
      states,
      statesPaginatedData,
      isLoading,
    }
  },
}
</script>
