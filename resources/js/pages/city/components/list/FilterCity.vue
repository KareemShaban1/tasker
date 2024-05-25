<template>
  <!-- <FilterButton @click="isFilter = true" /> -->

  <VNavigationDrawer
    v-model="isFilter"
    location="right"
    temporary
    width="500"
    class="drawerFilter"
  >
    <VCard class="h-100 d-flex flex-column justify-space-between">
      <div>
        <VCardTitle class="headline d-flex align-center justify-space-between">
          Filters
        </VCardTitle>
        <VDivider />
        <VCardText class="mt-2">
          <VRow>
            <VCol cols="12">
              <VTextField
                v-model="query.name"
                label="Search City"
                clearable
                @update:model-value="getResults"
              />
            </VCol>

            <VCol cols="12">
              <VSelect
                v-model="query.per_page"
                label="Page Size"
                :items="[10, 20, 30, 40, 50]"
                @update:model-value="getResults"
              />
            </VCol>
          </VRow>
        </VCardText>
      </div>
      <div>
        <VDivider />
        <VCardActions>
          <VSpacer />
          <VBtn
            color="secondary"
            @click="clearFilter"
          >
            Clear
          </VBtn>
          <VBtn @click="handleFilters">
            Done
          </VBtn>
        </VCardActions>
      </div>
    </VCard>
  </VNavigationDrawer>
</template>

<script>
// eslint-disable-next-line no-restricted-imports
// import FilterButton from '@/layouts/components/FilterButton.vue'
import { mapActions, mapGetters, mapMutations } from 'vuex'

export default {
  name: 'FilterCity',

  // components: { FilterButton },
  props: {
    query: {
      type: Object,
      required: true,
    },
  },

  setup() {
    const isFilter = ref(false)
    const hasFilter = ref(false)

    const items = [
      {
        state: 'All Data',
        value: 'true',
      },
    ]

    return {
      items,
      isFilter,
      hasFilter,
    }
  },
  computed: { ...mapGetters('City', ['isLoading', 'filterItems']) },

  methods: {
    ...mapActions('City', ['fetchAllCities']),
    ...mapMutations('City', ['setIsLoading', 'setHasFilter', 'setFilterItems']),

    getResults() {
      this.query.page = 1
      this.fetchAllCities(this.query)
      this.setHasFilter(true)
    },

    showFilter() {
      return (this.isFilter = !this.isFilter)
    },

    handleFilters() {
      this.isFilter = false
      this.setHasFilter(true)
    },

    async clearFilter() {
      try {
        this.setIsLoading(true)
        this.query.paginate = true
        this.query.name = ''

        await this.fetchAllCities(this.query)

        this.isFilter = false // Reset isFilter variable
        this.setHasFilter(false) // Reset hasFilter variable (assuming you have it declared somewhere)
      } catch (error) {
        console.error('Data Error:', error)
      } finally {
        this.setIsLoading(false)
      }
    },
  },
}
</script>
