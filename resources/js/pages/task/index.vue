<template>
  <TaskIndex />

  <!-- Edit Dialog Part -->
  <EditTask
    v-if="isUpdating"
    v-model="isUpdating"
  />

  <!-- Create Dialog Part -->
  <CreateTask
    v-if="isCreating"
    v-model="isCreating"
  />
</template>

<script>
import TaskIndex from "@/pages/task/components/TaskIndex.vue"
import CreateTask from "@/pages/task/components/create/CreateTask.vue"
import EditTask from "@/pages/task/components/edit/EditTask.vue"

import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  components: { TaskIndex, CreateTask, EditTask },

  setup() {
    const store = useStore()
    const isCreating = computed(() => store.getters['Task/isCreating'])
    const isUpdating = computed(() => store.getters['Task/isUpdating'])

    return {
      isCreating,
      isUpdating,
    }
  },
}
</script>
