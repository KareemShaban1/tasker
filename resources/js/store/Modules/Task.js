import useHandler from "@/services/handler"
import useTasks from "@/services/Modules/TaskService"

const { displayError, setQueryParamsToUrl } = useHandler()

const {
  tasks,
  task,
  paginatedData,
  getTasks,
  getTask,
  storeTask,
  editTask,
  updateTask,
  destroyTask,
  forceDeleteTask,
  restoreTask,
} = useTasks()

const state = () => ({
  tasks: [],
  task: null,
  paginatedData: null,

  isLoading: true,
  isCreating: false,
  isUpdating: false,

  isFullData: false,
  createdData: null,
  editTaskId: null,
  updatedData: null,
  isDeleting: false,
  deletedData: null,

  isHasFilter: false,
  filterItems: [],
})

const getters = {
  tasksList: state => state.tasks,
  task: state => state.task,
  paginatedData: state => state.paginatedData,

  isLoading: state => state.isLoading,
  isCreating: state => state.isCreating,
  isUpdating: state => state.isUpdating,

  isFullData: state => state.isFullData,

  createdData: state => state.createdData,
  editTaskId: state => state.editTaskId,
  updatedData: state => state.updatedData,

  isDeleting: state => state.isDeleting,
  deletedData: state => state.deletedData,

  isHasFilter: state => state.isHasFilter,
  filterItems: state => state.filterItems,
}

const actions = {
  async fetchAll({ commit }, query = null) {
    try {
      commit('setIsLoading', true)
      await getTasks(query)
      commit('setTasks', tasks.value)
      commit('setTasksPaginatedData', paginatedData.value)
      commit('setIsLoading', false)
      setQueryParamsToUrl(query)
      commit('setFilterItems', { pagination: query?.per_page, task: query?.name_en, department: query?.department_name })
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async fetchTask({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await getTask(id)
      commit('setTaskDetail', task.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async storeTask({ commit }, task) {
    try {
      commit('setIsCreating', true)
      await storeTask(task)
      commit('saveNewTasks', task.value)
      commit('setIsCreating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async editTask({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await editTask(id)
      commit('setTaskDetail', task.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async updateTask({ commit }, task) {
    try {
      commit('setIsUpdating', true)
      await updateTask(task)
      commit('saveUpdatedTask', task.value)
      commit('setIsUpdating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async deleteTask({ commit }, id) {
    try {
      await destroyTask(id)
      commit('setDeleteTask', id)
    } catch (error) {
      displayError(error)
    }
  },

  async forceDeleteTask({ commit }, id) {
    try {
      await forceDeleteTask(id)
      commit('setDeleteTask', id)
    } catch (error) {
      displayError(error)
    }
  },
  async restoreTask({ commit }, id) {
    try {
      await restoreTask(id)
    } catch (error) {
      displayError(error)
    }
  },

}

const mutations = {
  setTasks: (state, tasks) => {
    state.tasks = tasks
  },

  setTasksPaginatedData: (state, paginatedData) => {
    state.paginatedData = paginatedData
  },

  setTaskDetail: (state, task) => {
    state.task = task
  },

  setIsLoading: (state, isLoading) => {
    state.isLoading = isLoading
  },
  setIsCreating: (state, isCreating) => {
    state.isCreating = isCreating
  },
  setIsUpdating: (state, isUpdating) => {
    state.isUpdating = isUpdating
  },
  saveNewTasks: (state, task) => {
    state.tasks.unshift(task)
    state.createdData = task
  },
  saveUpdatedTask: (state, task) => {
    state.updatedData = task
  },
  setDeleteTask: (state, id) => {
    state.paginatedData.data.filter(x => x.id !== id)
  },

  setHasFilter: (state, hasFilter) => {
    state.isHasFilter = hasFilter
  },

  setFilterItems: (state, { pagination, task, department }) => {
    const filterItems = []

    if (task) {
      filterItems.push({
        name: 'task',
        filterData: task,
        clearFilter: 'name_en',
      })
    }

    if (pagination) {
      filterItems.push({
        name: 'Page Size',
        filterData: pagination,
      })
    }

    state.filterItems = filterItems
  },
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
}
