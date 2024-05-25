<template>
  <td>
    {{ index }}
  </td>
  <td class="text-capitalize">
    {{ language.name }}
  </td>
  <td class="text-capitalize">
    <span class="date">{{ humanReadableDate(language.created_at).date }}</span>
    <br>
    <span class="time">{{ humanReadableDate(language.created_at).time }}</span>
  </td>

  <td class="d-flex gap-1 justify-center align-center">
    <VBtn
      v-if="language.deleted_at == null"
      color="warning"
      size="small"
      class="me-1"
      title="Edit language"
      @click="editLanguageModel(language)"
    >
      <VIcon icon="ri-edit-box-line" />
    </VBtn>
    <VBtn
      v-if="language.deleted_at == null"
      size="small"
      class="me-1 bg-error text-capitalize"
      title="Delete language"
      color="error"
      @click="deleteLanguageModal(language.id)"
    >
      <VIcon icon="ri-delete-bin-line" />
    </VBtn>

    <VBtn
      v-if="language.deleted_at !== null"
      size="small"
      rounded="lg"
      color="warning"
      class="me-1 text-capitalize"
      title="restore language"
      @click="restoreLanguageModal(language.id)"
    >
      <VIcon icon="ri-arrow-turn-forward-line" />
    </VBtn>
    <VBtn
      v-if="language.deleted_at !== null"
      size="small"
      rounded="lg"
      color="primary"
      class="me-1 text-capitalize"
      title="Force delete language"
      @click="forceDeleteLanguageModal(language.id)"
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
  name: "LanguageDetail",
  props: {
    language: {
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
    ...mapMutations("Language", ["setIsUpdating"]),

    ...mapActions('Language', ['fetchAllLanguages', 'deleteLanguage', 'restoreLanguage', 'forceDeleteLanguage', 'editLanguage']),

    forceDeleteLanguageModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.forceDeleteLanguage(id).then(() => {
            this.fetchAllLanguages(getQueryParamsFromUrl())
          })
        }
      })
    },

    deleteLanguageModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteLanguage(id).then(() => {
            this.fetchAllLanguages(getQueryParamsFromUrl())
          })
        }
      })
    },

    restoreLanguageModal(id) {
      Swal.fire({
        title: 'Are you sure ?',
        showCancelButton: true,
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.restoreLanguage(id).then(() => {
            this.fetchAllLanguages(getQueryParamsFromUrl())
          })
        }
      })
    },

    BulkDeleteLanguageModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteLanguage(id).then(() => {
            this.fetchAllLanguages(getQueryParamsFromUrl())
          })
        }
      })
    },

    editLanguageModel(language) {
      this.editLanguage(language.id)
    },
  },
}
</script>
