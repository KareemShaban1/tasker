<template>
  <Header
  title="Task"
  create-component
  create-title="Create new task"
  store="Task"
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
                Image
              </th>
              <th class="text-capitalize">
                Title
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
              v-for="(task, index) in tasks"
              :key="task.id"
            >
              <TaskDetails
                :index="
                  (paginatedData.pagination.current_page - 1) * paginatedData.pagination.per_page +
                    index +
                    1
                "
                :task="task"
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

    <PaginationComponent :query="query" store="Task" />
  </div>
</template>

<script>
import TaskDetails from '@/pages/task/components/list/TaskDetails.vue'
import PaginationComponent from '@/components/PaginationComponent.vue'
import Header from "@/components/Header.vue"
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'TaskIndex',
  components: { TaskDetails, Header, PaginationComponent },

  setup() {
    const store = useStore()

    const tasks = computed(() => store.getters['Task/tasksList'])
    const paginatedData = computed(() => store.getters['Task/paginatedData'])
    const isLoading = computed(() => store.getters['Task/isLoading'])

    const fetchAll = () => {
      store.dispatch('Task/fetchAll', query)
    }

    onMounted(() => {
      fetchAll()
    })

    const query = reactive({
      page: 1,
      per_page: 10,
      title: '',
      paginate: true,
      full_data: true,
      with_trashed: true,
    })

    return {
      query,
      tasks,
      paginatedData,
      isLoading,
    }
  },
}
</script>
