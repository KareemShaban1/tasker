import useHandler from "@/services/handler"
import useTaskTypes from "@/services/Modules/TaskTypeService"

const { displayError, setQueryParamsToUrl } = useHandler()

const {
  taskTypes,
  taskType,
  taskTypesPaginatedData,
  getTaskTypes,
  getTaskType,
  storeTaskType,
  editTaskType,
  updateTaskType,
  destroyTaskType,
  forceDeleteTaskType,
  restoreTaskType,
} = useTaskTypes()

const state = () => ({
  taskTypes: [],
  taskType: null,
  taskTypesPaginatedData: null,

  isLoading: true,
  isCreating: false,
  isUpdating: false,

  isFullData: false,
  createdData: null,
  editTaskTypeId: null,
  updatedData: null,
  isDeleting: false,
  deletedData: null,

  isHasFilter: false,
  filterItems: [],
})

const getters = {
  taskTypesList: state => state.taskTypes,
  taskType: state => state.taskType,
  taskTypesPaginatedData: state => state.taskTypesPaginatedData,

  isLoading: state => state.isLoading,
  isCreating: state => state.isCreating,
  isUpdating: state => state.isUpdating,

  isFullData: state => state.isFullData,

  createdData: state => state.createdData,
  editTaskTypeId: state => state.editTaskTypeId,
  updatedData: state => state.updatedData,

  isDeleting: state => state.isDeleting,
  deletedData: state => state.deletedData,

  isHasFilter: state => state.isHasFilter,
  filterItems: state => state.filterItems,
}

const actions = {
  async fetchAllTaskTypes({ commit }, query = null) {
    try {
      commit('setIsLoading', true)
      await getTaskTypes(query)
      commit('setTaskTypes', taskTypes.value)
      commit('setTaskTypesPaginatedData', taskTypesPaginatedData.value)
      commit('setIsLoading', false)
      setQueryParamsToUrl(query)
      commit('setFilterItems', { pagination: query?.per_page, taskType: query?.name_en, department: query?.department_name })
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async fetchTaskType({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await getTaskType(id)
      commit('setTaskTypeDetail', taskType.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async storeTaskType({ commit }, taskType) {
    try {
      commit('setIsCreating', true)
      await storeTaskType(taskType)
      commit('saveNewTaskTypes', taskType.value)
      commit('setIsCreating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async editTaskType({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await editTaskType(id)
      commit('setTaskTypeDetail', taskType.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async updateTaskType({ commit }, taskType) {
    try {
      commit('setIsUpdating', true)
      await updateTaskType(taskType)
      commit('saveUpdatedTaskType', taskType.value)
      commit('setIsUpdating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async deleteTaskType({ commit }, id) {
    try {
      await destroyTaskType(id)
      commit('setDeleteTaskType', id)
    } catch (error) {
      displayError(error)
    }
  },

  async forceDeleteTaskType({ commit }, id) {
    try {
      await forceDeleteTaskType(id)
      commit('setDeleteTaskType', id)
    } catch (error) {
      displayError(error)
    }
  },
  async restoreTaskType({ commit }, id) {
    try {
      await restoreTaskType(id)
    } catch (error) {
      displayError(error)
    }
  },

}

const mutations = {
  setTaskTypes: (state, taskTypes) => {
    state.taskTypes = taskTypes
  },

  setTaskTypesPaginatedData: (state, taskTypesPaginatedData) => {
    state.taskTypesPaginatedData = taskTypesPaginatedData
  },

  setTaskTypeDetail: (state, taskType) => {
    state.taskType = taskType
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
  saveNewTaskTypes: (state, taskType) => {
    state.taskTypes.unshift(taskType)
    state.createdData = taskType
  },
  saveUpdatedTaskType: (state, taskType) => {
    state.updatedData = taskType
  },
  setDeleteTaskType: (state, id) => {
    state.taskTypesPaginatedData.data.filter(x => x.id !== id)
  },

  setHasFilter: (state, hasFilter) => {
    state.isHasFilter = hasFilter
  },

  setFilterItems: (state, { pagination, taskType, department }) => {
    const filterItems = []

    if (taskType) {
      filterItems.push({
        name: 'taskType',
        filterData: taskType,
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
