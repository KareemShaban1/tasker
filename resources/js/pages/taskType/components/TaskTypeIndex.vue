<template>
  <Header
  title="Task Type"
  create-component
  create-title="Create new task type"
  store="TaskType"
  :query="query"
  :selected-ids="selectedIds"
  @clear-selected="updateSelectedIds"
/>
<div>
    <VCard>
      <VCardText>
        <VTable>
          <thead>
            <tr>
              <th class="text-capitalize">
                #
              </th>
              <th class="text-capitalize">
                Type
              </th>
              <th class="text-capitalize">
                Language
              </th>
              <th class="text-capitalize">
                created at
              </th>
              <th class="text-capitalize text-center">
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(taskType, index) in taskTypes"
              :key="taskType.id"
            >
              <TaskTypeDetails
                :index="
                  (paginatedData.pagination.current_page - 1) * paginatedData.pagination.per_page +
                    index +
                    1
                "
                :task-type="taskType"
                :query="query"
              />
            </tr>
            <div
              v-if="isLoading"
              class="loading-page"
            >
              <VProgressCircular
                :per_page="50"
                color="primary"
                indeterminate
              />
            </div>
          </tbody>
        </VTable>
      </VCardText>
    </VCard>

    <PaginationComponent :query="query"  store="TaskType" />
  </div>
</template>

<script>
import TaskTypeDetails from '@/pages/taskType/components/list/TaskTypeDetails.vue'
import PaginationComponent from '@/components/PaginationComponent.vue'
import Header from "@/components/Header.vue"
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'TaskTypeIndex',
  components: { TaskTypeDetails, Header, PaginationComponent },

  setup() {
    const store = useStore()

    const taskTypes = computed(() => store.getters['TaskType/taskTypesList'])
    const paginatedData = computed(() => store.getters['TaskType/paginatedData'])
    const isLoading = computed(() => store.getters['TaskType/isLoading'])

    const fetchAll = () => {
      store.dispatch('TaskType/fetchAll', query)
    }

    onMounted(() => {
      fetchAll()
    })

    const query = reactive({
      page: 1,
      per_page: 10,
      type: '',
      paginate: true,
      full_data: true,
      with_trashed: true,
    })

    return {
      query,
      taskTypes,
      paginatedData,
      isLoading,
    }
  },
}
</script>
