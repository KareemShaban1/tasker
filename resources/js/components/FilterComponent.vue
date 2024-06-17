<template>
  <FilterButton @click="isFilter = true" />

  <VNavigationDrawer
    v-model="isFilter"
    location="right"
    temporary
    width="500"
    class="drawerFilter"
  >
    <VCard class="h-100 d-flex flex-column justify-space-between">
      <VCardTitle class="headline d-flex align-center justify-space-between">
        Filters
      </VCardTitle>
      <VDivider />
      <Component
        :is="store"
        :get-results="getResults"
        :query="query"
      />
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
import FilterButton from '@/components/FilterButton.vue'
import Offer from "@/pages/offer/components/list/FilterCard.vue"
import Country from "@/pages/country/components/list/FilterCard.vue"
import City from "@/pages/city/components/list/FilterCard.vue"
import State from "@/pages/state/components/list/FilterCard.vue"
import Language from "@/pages/language/components/list/FilterCard.vue"
import TaskType from "@/pages/taskType/components/list/FilterCard.vue"
import Category from "@/pages/category/components/list/FilterCard.vue"
import Specialty from "@/pages/specialty/components/list/FilterCard.vue"
import Client from "@/pages/client/components/list/FilterCard.vue"

import useHandler from "@/services/handler"
import { useStore } from "vuex"

export default {
  name: "FilterComponent",
  components: {
    FilterButton,
    Offer,
    Country,
    City,
    State,
    Language,
    TaskType,
    Category,
    Specialty,
    Client,
  },
  props: {
    query: {
      type: Object,
      required: true,
    },
    store: {
      type: String,
      required: true,
    },
  },

  setup(props) {
    const { clearFilterItems } = useHandler()

    let isFilter = ref(false)
    const hasFilter = ref(false)
    const store = useStore()

    onMounted( () => {
      console.info(props.store)
    })

    const isLoading = computed(() => store.getters([props.store + '/isLoading']))
    const filterItems = computed(() => store.getters([props.store + '/filterItems']))

    const setHasFilter = value => {
      store.commit(props.store + '/setHasFilter', value)
    }

    const setFilterItems = value => {
      store.commit(props.store + '/setFilterItems', value)
    }

    const setIsLoading = value => {
      store.commit(props.store + '/setIsLoading', value)
    }

    const getResults = () => {
      store.dispatch(props.store + '/fetchAll', props.query)
      setHasFilter(true)
    }

    const showFilter = () => {
      return isFilter.value = !isFilter.value
    }

    const handleFilters = () => {
      isFilter.value = false
      setHasFilter(true)
    }

    const fetchAll = () => {
      store.dispatch(props.store + '/fetchAll', props.query)
    }

    const clearFilter = async () => {
      try {
        setIsLoading(true)
        clearFilterItems(props.query)
        fetchAll()
        isFilter.value = false
        setHasFilter(false)
      } catch (error) {
        console.error('Data Error:', error)
      } finally {
        setIsLoading(false)
      }
    }

    return {
      isFilter,
      hasFilter,
      setHasFilter,
      setFilterItems,
      setIsLoading,
      getResults,
      showFilter,
      handleFilters,
      clearFilter,
    }
  },
}
</script>
