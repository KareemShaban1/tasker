<template>
  <Header
  title="Clients"
  create-component
  create-title="Create new client"
  store="Client"
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
              v-for="(client,index) in clients"
              :key="client.id"
            >
              <ClientDetails
                :index="(clientsPaginatedData.pagination.current_page - 1) * clientsPaginatedData.pagination.per_page + index + 1"
                :client="client"
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
import ClientDetails from "@/pages/client/components/list/ClientDetails.vue"
import Header from "@/components/Header.vue"
import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  name: 'ClientIndex',
  components: { ClientDetails, Header },

  setup() {
    const store = useStore()

    const clients = computed(() => store.getters['Client/clientsList'])
    const clientsPaginatedData = computed(() => store.getters['Client/clientsPaginatedData'])
    const isLoading = computed(() => store.getters['Client/isLoading'])

    const fetchAll = () => {
      store.dispatch('Client/fetchAll', query)
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
      clients,
      clientsPaginatedData,
      isLoading,
    }
  },
}
</script>
