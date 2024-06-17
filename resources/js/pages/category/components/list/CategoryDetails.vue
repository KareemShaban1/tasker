<template>
  <td>
    {{ index }}
  </td>
  <td class="text-capitalize">
    {{ category.name }}
  </td>
  <td class="text-capitalize">
    {{ category.language?.name }}
  </td>
  <td class="text-capitalize">
    <span class="date">{{ humanReadableDate(category.created_at).date }}</span>
    <br>
    <span class="time">{{ humanReadableDate(category.created_at).time }}</span>
  </td>

  <td class="d-flex gap-1 justify-center align-center">
    <VBtn
      v-if="category.deleted_at == null"
      color="warning"
      size="small"
      class="me-1"
      title="Edit category"
      @click="editCategoryModel(category)"
    >
      <VIcon icon="ri-edit-box-line" />
    </VBtn>
    <VBtn
      v-if="category.deleted_at == null"
      size="small"
      class="me-1 bg-error text-capitalize"
      title="Delete category"
      color="error"
      @click="deleteCategoryModal(category.id)"
    >
      <VIcon icon="ri-delete-bin-line" />
    </VBtn>

    <VBtn
      v-if="category.deleted_at !== null"
      size="small"
      rounded="lg"
      color="warning"
      class="me-1 text-capitalize"
      title="restore category"
      @click="restoreCategoryModal(category.id)"
    >
      <VIcon icon="ri-arrow-turn-forward-line" />
    </VBtn>
    <VBtn
      v-if="category.deleted_at !== null"
      size="small"
      rounded="lg"
      color="primary"
      class="me-1 text-capitalize"
      title="Force delete category"
      @click="forceDeleteCategoryModal(category.id)"
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
  name: "CategoryDetail",
  props: {
    category: {
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
    ...mapMutations("Category", ["setIsUpdating"]),

    ...mapActions('Category', ['fetchAll', 'deleteCategory', 'restoreCategory', 'forceDeleteCategory', 'editCategory']),

    forceDeleteCategoryModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.forceDeleteCategory(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    deleteCategoryModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteCategory(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    restoreCategoryModal(id) {
      Swal.fire({
        title: 'Are you sure ?',
        showCancelButton: true,
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.restoreCategory(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    BulkDeleteCategoryModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteCategory(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    editCategoryModel(category) {
      this.editCategory(category.id)
    },
  },
}
</script>
