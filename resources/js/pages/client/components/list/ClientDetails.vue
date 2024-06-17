<template>
  <td>
    {{ index }}
  </td>
  <td class="text-capitalize">
    {{ client.name }}
  </td>
  <td class="text-capitalize">
    {{ client.country?.name }}
  </td>
  <td class="text-capitalize">
    <span class="date">{{ humanReadableDate(client.created_at).date }}</span>
    <br>
    <span class="time">{{ humanReadableDate(client.created_at).time }}</span>
  </td>

  <td class="d-flex gap-1 justify-center align-center">
    <VBtn
      v-if="client.deleted_at == null"
      color="warning"
      size="small"
      class="me-1"
      title="Edit client"
      @click="editClientModel(client)"
    >
      <VIcon icon="ri-edit-box-line" />
    </VBtn>
    <VBtn
      v-if="client.deleted_at == null"
      size="small"
      class="me-1 bg-error text-capitalize"
      title="Delete client"
      color="error"
      @click="deleteClientModal(client.id)"
    >
      <VIcon icon="ri-delete-bin-line" />
    </VBtn>

    <VBtn
      v-if="client.deleted_at !== null"
      size="small"
      rounded="lg"
      color="warning"
      class="me-1 text-capitalize"
      title="restore client"
      @click="restoreClientModal(client.id)"
    >
      <VIcon icon="ri-arrow-turn-forward-line" />
    </VBtn>
    <VBtn
      v-if="client.deleted_at !== null"
      size="small"
      rounded="lg"
      color="primary"
      class="me-1 text-capitalize"
      title="Force delete client"
      @click="forceDeleteClientModal(client.id)"
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
  name: "ClientDetail",
  props: {
    client: {
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
    ...mapMutations("Client", ["setIsUpdating"]),

    ...mapActions('Client', ['fetchAll', 'deleteClient', 'restoreClient', 'forceDeleteClient', 'editClient']),

    forceDeleteClientModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.forceDeleteClient(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    deleteClientModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteClient(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    restoreClientModal(id) {
      Swal.fire({
        title: 'Are you sure ?',
        showCancelButton: true,
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.restoreClient(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    BulkDeleteClientModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteClient(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    editClientModel(client) {
      this.editClient(client.id)
    },
  },
}
</script>
