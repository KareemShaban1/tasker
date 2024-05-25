<template>
  <td>
    {{ index }}
  </td>
  <td class="text-capitalize">
    {{ state.name }}
  </td>
  <td class="text-capitalize">
    {{ state.city?.name }}
  </td>
  <td class="text-capitalize">
    <span class="date">{{ humanReadableDate(state.created_at).date }}</span>
    <br>
    <span class="time">{{ humanReadableDate(state.created_at).time }}</span>
  </td>

  <td class="d-flex gap-1 justify-center align-center">
    <VBtn
      v-if="state.deleted_at == null"
      color="warning"
      size="small"
      class="me-1"
      title="Edit state"
      @click="editStateModel(state)"
    >
      <VIcon icon="ri-edit-box-line" />
    </VBtn>
    <VBtn
      v-if="state.deleted_at == null"
      size="small"
      class="me-1 bg-error text-capitalize"
      title="Delete state"
      color="error"
      @click="deleteStateModal(state.id)"
    >
      <VIcon icon="ri-delete-bin-line" />
    </VBtn>

    <VBtn
      v-if="state.deleted_at !== null"
      size="small"
      rounded="lg"
      color="warning"
      class="me-1 text-capitalize"
      title="restore state"
      @click="restoreStateModal(state.id)"
    >
      <VIcon icon="ri:arrow-turn-forward-line" />
    </VBtn>
    <VBtn
      v-if="state.deleted_at !== null"
      size="small"
      rounded="lg"
      color="primary"
      class="me-1 text-capitalize"
      title="Force delete state"
      @click="forceDeleteStateModal(state.id)"
    >
      <VIcon icon="ri-delete-bin-line" />
    </VBtn>
  </td>
</template>

<script>
import useHandler from "@/services/handler"
import Swal from "sweetalert2"
import { mapActions, mapMutations } from "vuex"


const { getQueryParamsFromUrl, humanReadableDate } = useHandler()

export default {
  name: "StateDetail",
  props: {
    state: {
      type: Object,
      required: true,
    },
    index: {
      type: Number,
      required: true,
      default: 0,
    },
  },
  setup() {
    const select = ref([])

    return {
      select,
      humanReadableDate,
    }
  },

  methods: {
    ...mapMutations("State", ["setIsUpdating"]),

    ...mapActions('State', ['fetchAllStates', 'deleteState', 'restoreState', 'forceDeleteState', 'editState']),

    forceDeleteStateModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.forceDeleteState(id).then(() => {
            this.fetchAllStates(getQueryParamsFromUrl())
          })
        }
      })
    },

    deleteStateModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteState(id).then(() => {
            this.fetchAllStates(getQueryParamsFromUrl())
          })
        }
      })
    },

    restoreStateModal(id) {
      Swal.fire({
        title: 'Are you sure ?',
        showCancelButton: true,
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.restoreState(id).then(() => {
            this.fetchAllStates(getQueryParamsFromUrl())
          })
        }
      })
    },

    BulkDeleteStateModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteState(id).then(() => {
            this.fetchAllStates(getQueryParamsFromUrl())
          })
        }
      })
    },

    editStateModel(state) {
      this.editState(state.id)
    },
  },
}
</script>
