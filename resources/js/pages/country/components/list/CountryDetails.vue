<template>
  <td>
    {{ index }}
  </td>
  <td class="text-capitalize">
    {{ country.name }}
  </td>
  <td class="text-capitalize">
    <span class="date">{{ humanReadableDate(country.created_at).date }}</span>
    <br>
    <span class="time">{{ humanReadableDate(country.created_at).time }}</span>
  </td>

  <td class="d-flex gap-1 justify-center align-center">
    <VBtn
      v-if="country.deleted_at == null"
      color="warning"
      size="small"
      class="me-1"
      title="Edit country"
      @click="editCountryModel(country)"
    >
      <VIcon icon="ri-edit-box-line" />
    </VBtn>
    <VBtn
      v-if="country.deleted_at == null"
      size="small"
      class="me-1 bg-error text-capitalize"
      title="Delete country"
      color="error"
      @click="deleteCountryModal(country.id)"
    >
      <VIcon icon="ri-delete-bin-line" />
    </VBtn>

    <VBtn
      v-if="country.deleted_at !== null"
      size="small"
      rounded="lg"
      color="warning"
      class="me-1 text-capitalize"
      title="restore country"
      @click="restoreCountryModal(country.id)"
    >
      <VIcon icon="ri-arrow-turn-forward-line" />
    </VBtn>
    <VBtn
      v-if="country.deleted_at !== null"
      size="small"
      rounded="lg"
      color="primary"
      class="me-1 text-capitalize"
      title="Force delete country"
      @click="forceDeleteCountryModal(country.id)"
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
  name: "CountryDetail",
  props: {
    country: {
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
    ...mapMutations("Country", ["setIsUpdating"]),

    ...mapActions('Country', ['fetchAllCountries', 'deleteCountry', 'restoreCountry', 'forceDeleteCountry', 'editCountry']),

    forceDeleteCountryModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.forceDeleteCountry(id).then(() => {
            this.fetchAllCountries(getQueryParamsFromUrl())
          })
        }
      })
    },

    deleteCountryModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteCountry(id).then(() => {
            this.fetchAllCountries(getQueryParamsFromUrl())
          })
        }
      })
    },

    restoreCountryModal(id) {
      Swal.fire({
        title: 'Are you sure ?',
        showCancelButton: true,
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.restoreCountry(id).then(() => {
            this.fetchAllCountries(getQueryParamsFromUrl())
          })
        }
      })
    },

    BulkDeleteCountryModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteCountry(id).then(() => {
            this.fetchAllCountries(getQueryParamsFromUrl())
          })
        }
      })
    },

    editCountryModel(country) {
      this.editCountry(country.id)
    },
  },
}
</script>
