<template>
  <td>
    {{ index }}
  </td>
  <td class="text-capitalize">
    {{ city.name }}
  </td>
  <td class="text-capitalize">
    {{ city.country?.name }}
  </td>
  <td class="text-capitalize">
    <span class="date">{{ humanReadableDate(city.created_at).date }}</span>
    <br>
    <span class="time">{{ humanReadableDate(city.created_at).time }}</span>
  </td>

  <td class="d-flex gap-1 justify-center align-center">
    <VBtn
      v-if="city.deleted_at == null"
      color="warning"
      size="small"
      class="me-1"
      title="Edit city"
      @click="editCityModel(city)"
    >
      <VIcon icon="ri-edit-box-line" />
    </VBtn>
    <VBtn
      v-if="city.deleted_at == null"
      size="small"
      class="me-1 bg-error text-capitalize"
      title="Delete city"
      color="error"
      @click="deleteCityModal(city.id)"
    >
      <VIcon icon="ri-delete-bin-line" />
    </VBtn>

    <VBtn
      v-if="city.deleted_at !== null"
      size="small"
      rounded="lg"
      color="warning"
      class="me-1 text-capitalize"
      title="restore city"
      @click="restoreCityModal(city.id)"
    >
      <VIcon icon="ri-arrow-turn-forward-line" />
    </VBtn>
    <VBtn
      v-if="city.deleted_at !== null"
      size="small"
      rounded="lg"
      color="primary"
      class="me-1 text-capitalize"
      title="Force delete city"
      @click="forceDeleteCityModal(city.id)"
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
  name: "CityDetail",
  props: {
    city: {
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
    ...mapMutations("City", ["setIsUpdating"]),

    ...mapActions('City', ['fetchAll', 'deleteCity', 'restoreCity', 'forceDeleteCity', 'editCity']),

    forceDeleteCityModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.forceDeleteCity(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    deleteCityModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteCity(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    restoreCityModal(id) {
      Swal.fire({
        title: 'Are you sure ?',
        showCancelButton: true,
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.restoreCity(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    BulkDeleteCityModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteCity(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    editCityModel(city) {
      this.editCity(city.id)
    },
  },
}
</script>
