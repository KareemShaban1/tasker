<template>
  <VCol
    lg="12"
    class="d-flex justify-space-between  align-start align-md-center flex-column flex-md-row"
  >
    <h1 class="w-100 text-capitalize">
      {{ title }}
    </h1>
    <div class="FilterData w-100 justify-md-end justify-space-between flex-wrap d-flex align-start gap-2">
      <FilterComponent
        :query="query"
        :store="store"
      />
      <VBtn
        v-if="createComponent"
        color="primary"
        size="small"
        class="text-capitalize"
        @click="create"
      >
        {{ createTitle }}
      </VBtn>
      <BulkDelete
        :store="store"
        :selected-ids="selectedIds"
        @clear-selected="clearSelected"
      />
    </div>
  </VCol>
  <div class="row mb-2">
    <div class="col-12">
      <ShowResult
        :query="query"
        :store="store"
      />
    </div>
  </div>
</template>

<script>
import FilterComponent from "@/components/FilterComponent.vue"
import ShowResult from "@/components/ShowFilterResult.vue"

// import BulkDelete from "@/components/BulkDelete.vue"
import { useStore } from "vuex"
import Swal from "sweetalert2"
import useHandler from "@/services/handler"

export default {
  components: {  FilterComponent, ShowResult },
  props: {
    query: {
      type: Object,
      required: true,
    },
    selectedIds: {
      type: Array,
      required: true,
    },
    store: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    createTitle: {
      type: String,
    },
    createComponent: {
      type: Boolean,
    },
    modelPermissions: {
      type: Object,
      required: true,
    },
  },

  setup(props, { emit }) {
    const { getQueryParamsFromUrl } = useHandler()
    const store = useStore()

    const setIsCreating = value => {
      store.commit(props.store + '/setIsCreating', value)
    }

    const create = () => {
      setIsCreating(true)
    }

    const clearSelected = () => {
      emit('clear-selected', [])
    }

    return {
      create,
      clearSelected,
    }
  },
}
</script>
