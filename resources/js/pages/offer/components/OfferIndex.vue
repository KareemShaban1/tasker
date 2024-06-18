<template>
  <Header
    title="Offer"
    create-component
    create-title="Create new offer"
    store="Offer"
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
                Offer
              </th>
              <th class="text-capitalize">
                Task Type
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
              v-for="(offer,index) in offers"
              :key="offer.id"
            >
              <OfferDetails
                :index="(paginatedData.pagination.current_page - 1) * paginatedData.pagination.per_page + index + 1"
                :offer="offer"
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

    <PaginationComponent :query="query" store="Offer"/>
  </div>
</template>

<script>
import OfferDetails from "@/pages/offer/components/list/OfferDetails.vue"
import PaginationComponent from '@/components/PaginationComponent.vue'
import Header from "@/components/Header.vue"
import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  name: 'OfferIndex',
  components: { OfferDetails, Header, PaginationComponent },

  setup() {
    const store = useStore()

    const offers = computed(() => store.getters['Offer/offersList'])
    const paginatedData = computed(() => store.getters['Offer/paginatedData'])
    const isLoading = computed(() => store.getters['Offer/isLoading'])

    const fetchAll = () => {
      store.dispatch('Offer/fetchAll', query)
    }

    onMounted(() => {
      fetchAll()
    })

    const query = reactive({
      page: 1,
      per_page: 10,
      offer: '',
      task_type: '',
      language: '',
      paginate: true,
      full_data: true,
      with_trashed: true,
    })

    return {
      query,
      offers,
      paginatedData,
      isLoading,
    }
  },
}
</script>
