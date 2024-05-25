<template>
  <TaskTypeIndex />

  <!-- Edit Dialog Part -->
  <EditTaskType
    v-if="isUpdating"
    v-model="isUpdating"
  />

  <!-- Create Dialog Part -->
  <CreateTaskType
    v-if="isCreating"
    v-model="isCreating"
  />
</template>

<script>
import TaskTypeIndex from "@/pages/taskType/components/TaskTypeIndex.vue"
import CreateTaskType from "@/pages/taskType/components/create/CreateTaskType.vue"
import EditTaskType from "@/pages/taskType/components/edit/EditTaskType.vue"

import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  components: { TaskTypeIndex, CreateTaskType, EditTaskType },

  setup() {
    const store = useStore()
    const isCreating = computed(() => store.getters['TaskType/isCreating'])
    const isUpdating = computed(() => store.getters['TaskType/isUpdating'])

    return {
      isCreating,
      isUpdating,
    }
  },
}
</script>
