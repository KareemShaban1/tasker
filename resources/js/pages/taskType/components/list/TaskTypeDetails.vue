<template>
  <td>
    {{ index }}
  </td>
  <td class="text-capitalize">
    {{ taskType.type }}
  </td>
  <td class="text-capitalize">
    <span class="date">{{ humanReadableDate(taskType.created_at).date }}</span>
    <br>
    <span class="time">{{ humanReadableDate(taskType.created_at).time }}</span>
  </td>

  <td class="d-flex gap-1 justify-center align-center">
    <VBtn
      v-if="taskType.deleted_at == null"
      color="warning"
      size="small"
      class="me-1"
      title="Edit taskType"
      @click="editTaskTypeModel(taskType)"
    >
      <VIcon icon="ri-edit-box-line" />
    </VBtn>
    <VBtn
      v-if="taskType.deleted_at == null"
      size="small"
      class="me-1 bg-error text-capitalize"
      title="Delete taskType"
      color="error"
      @click="deleteTaskTypeModal(taskType.id)"
    >
      <VIcon icon="ri-delete-bin-line" />
    </VBtn>

    <VBtn
      v-if="taskType.deleted_at !== null"
      size="small"
      rounded="lg"
      color="warning"
      class="me-1 text-capitalize"
      title="restore taskType"
      @click="restoreTaskTypeModal(taskType.id)"
    >
      <VIcon icon="ri-arrow-turn-forward-line" />
    </VBtn>
    <VBtn
      v-if="taskType.deleted_at !== null"
      size="small"
      rounded="lg"
      color="primary"
      class="me-1 text-capitalize"
      title="Force delete taskType"
      @click="forceDeleteTaskTypeModal(taskType.id)"
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
  name: "TaskTypeDetail",
  props: {
    taskType: {
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
    ...mapMutations("TaskType", ["setIsUpdating"]),

    ...mapActions('TaskType', ['fetchAllTaskTypes', 'deleteTaskType', 'restoreTaskType', 'forceDeleteTaskType', 'editTaskType']),

    forceDeleteTaskTypeModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.forceDeleteTaskType(id).then(() => {
            this.fetchAllTaskTypes(getQueryParamsFromUrl())
          })
        }
      })
    },

    deleteTaskTypeModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteTaskType(id).then(() => {
            this.fetchAllTaskTypes(getQueryParamsFromUrl())
          })
        }
      })
    },

    restoreTaskTypeModal(id) {
      Swal.fire({
        title: 'Are you sure ?',
        showCancelButton: true,
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.restoreTaskType(id).then(() => {
            this.fetchAllTaskTypes(getQueryParamsFromUrl())
          })
        }
      })
    },

    BulkDeleteTaskTypeModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteTaskType(id).then(() => {
            this.fetchAllTaskTypes(getQueryParamsFromUrl())
          })
        }
      })
    },

    editTaskTypeModel(taskType) {
      this.editTaskType(taskType.id)
    },
  },
}
</script>
