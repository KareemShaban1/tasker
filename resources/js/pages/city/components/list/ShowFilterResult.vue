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
              :md="filterItems.length>2?'6':'12'"
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
import { mapActions, mapGetters } from "vuex"

export default {
  props: {
    query: {
      type: Object,
      required: true,
    },
  },
  computed: { ...mapGetters('City', ['filterItems', 'isHasFilter']) },

  methods: {

    ...mapActions("City", ["fetchAllCities"]),

    clearSingleFilter(action) {
      this.query[action] = null
      this.fetchAllPositions(this.query)
    },

  },

 
}
</script>
