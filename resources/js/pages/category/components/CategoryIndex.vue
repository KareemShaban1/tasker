<template>
  <Header
  title="Category"
  create-component
  create-title="Create new category"
  store="Category"
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
              <th class="text-capitalize">#</th>
              <th class="text-capitalize">Name</th>
              <th class="text-capitalize">Language</th>
              <th class="text-capitalize">created at</th>
              <th class="text-capitalize text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(category, index) in categories"
              :key="category.id"
            >
              <CategoryDetails
                :index="
                  (paginatedData.pagination.current_page - 1) * paginatedData.pagination.per_page +
                  index +
                  1
                "
                :category="category"
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

    <PaginationComponent :query="query" store="Category"  />
  </div>
</template>

<script>
import CategoryDetails from '@/pages/category/components/list/CategoryDetails.vue'
import PaginationComponent from '@/components/PaginationComponent.vue'
import Header from "@/components/Header.vue"
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'CategoryIndex',
  components: { CategoryDetails, Header , PaginationComponent },

  setup() {
    const store = useStore()

    const categories = computed(() => store.getters['Category/categoriesList'])
    const paginatedData = computed(() => store.getters['Category/paginatedData'])
    const isLoading = computed(() => store.getters['Category/isLoading'])

    const fetchAll = () => {
      store.dispatch('Category/fetchAll', query)
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
      categories,
      paginatedData,
      isLoading,
    }
  },
}
</script>
