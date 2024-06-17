<template>
  <div v-if="isHasFilter">
    <VExpansionPanels multiple>
      <VExpansionPanel>
        <VExpansionPanelTitle>
          Filters Data ({{ filterItems.length }})
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="text-body-2 ">
            <VCol
              v-for="(item, index) in filterItems"
              :key="index"
              cols="12"
              :md="filterItems.length> 1 ? '3' : '6'"
              class="filter"
            >
              <span class="d-flex align-center gap-4 text-capitalize">
                {{ item.name }}
                <VBtn
                  v-if="item.clearFilter"
                  color="secondary"
                  size="x-small"
                  @click="clearSingleFilter(item.clearFilter)"
                >
                  <VIcon icon="ri-close-fill" />
                  <VTooltip
                    open-delay="500"
                    location="top"
                    activator="parent"
                  >
                    <span>clear</span>
                  </VTooltip>
                </VBtn>
              </span>
              <span class="text-primary d-block text-capitalize">
                {{ item.filterData }} {{ item.filterDataAr ? " || " + item.filterDataAr : '' }}</span>
            </VCol>
          </VRow>
        </VExpansionPanelText>
      </VExpansionPanel>
    </VExpansionPanels>
  </div>
</template>

<script>
import { useStore } from "vuex"
import { computed, onMounted } from "vue"

export default {
  name: 'FilterResult',

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
    const store = useStore()

    const filterItems = computed(() => store.getters[props.store + '/filterItems'])
    const isHasFilter = computed(() => store.getters[props.store + '/isHasFilter'])

    const fetchAll = query => {
      store.dispatch(props.store + '/fetchAll', query)
    }

    const clearSingleFilter = action => {
      props.query[action] = null
      fetchAll(props.query)
    }

    return {
      filterItems,
      isHasFilter,
      clearSingleFilter,
    }
  },
}
</script>
