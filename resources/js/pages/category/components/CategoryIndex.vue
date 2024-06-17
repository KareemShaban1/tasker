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
                  (categoriesPaginatedData.pagination.current_page - 1) * categoriesPaginatedData.pagination.per_page +
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

    <!-- <Pagination :query="query" /> -->
  </div>
</template>

<script>
import CategoryDetails from '@/pages/category/components/list/CategoryDetails.vue'
import Header from "@/components/Header.vue"
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'CategoryIndex',
  components: { CategoryDetails, Header },

  setup() {
    const store = useStore()

    const categories = computed(() => store.getters['Category/categoriesList'])
    const categoriesPaginatedData = computed(() => store.getters['Category/categoriesPaginatedData'])
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
      categoriesPaginatedData,
      isLoading,
    }
  },
}
</script>
