<template>
  <td>
    {{ index }}
  </td>
  <td class="text-capitalize">
    {{ specialty.name }}
  </td>
  <td class="text-capitalize">
    <span class="date">{{ humanReadableDate(specialty.created_at).date }}</span>
    <br>
    <span class="time">{{ humanReadableDate(specialty.created_at).time }}</span>
  </td>

  <td class="d-flex gap-1 justify-center align-center">
    <VBtn
      v-if="specialty.deleted_at == null"
      color="warning"
      size="small"
      class="me-1"
      title="Edit specialty"
      @click="editSpecialtyModel(specialty)"
    >
      <VIcon icon="ri-edit-box-line" />
    </VBtn>
    <VBtn
      v-if="specialty.deleted_at == null"
      size="small"
      class="me-1 bg-error text-capitalize"
      title="Delete specialty"
      color="error"
      @click="deleteSpecialtyModal(specialty.id)"
    >
      <VIcon icon="ri-delete-bin-line" />
    </VBtn>

    <VBtn
      v-if="specialty.deleted_at !== null"
      size="small"
      rounded="lg"
      color="warning"
      class="me-1 text-capitalize"
      title="restore specialty"
      @click="restoreSpecialtyModal(specialty.id)"
    >
      <VIcon icon="ri-arrow-turn-forward-line" />
    </VBtn>
    <VBtn
      v-if="specialty.deleted_at !== null"
      size="small"
      rounded="lg"
      color="primary"
      class="me-1 text-capitalize"
      title="Force delete specialty"
      @click="forceDeleteSpecialtyModal(specialty.id)"
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
  name: "SpecialtyDetail",
  props: {
    specialty: {
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
    ...mapMutations("Specialty", ["setIsUpdating"]),

    ...mapActions('Specialty', ['fetchAll', 'deleteSpecialty', 'restoreSpecialty', 'forceDeleteSpecialty', 'editSpecialty']),

    forceDeleteSpecialtyModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.forceDeleteSpecialty(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    deleteSpecialtyModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteSpecialty(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    restoreSpecialtyModal(id) {
      Swal.fire({
        title: 'Are you sure ?',
        showCancelButton: true,
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.restoreSpecialty(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    BulkDeleteSpecialtyModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteSpecialty(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    editSpecialtyModel(specialty) {
      this.editSpecialty(specialty.id)
    },
  },
}
</script>
