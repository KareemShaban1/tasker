import useHandler from '@/services/handler'
import useStates from '@/services/Modules/StateService'

const { displayError, setQueryParamsToUrl } = useHandler()

const {
  states,
  statee,
  statesPaginatedData,
  getStates,
  getState,
  storeState,
  editState,
  updateState,
  destroyState,
  forceDeleteState,
  restoreState,
} = useStates()

const state = () => ({
  states: [],
  statee: null,
  statesPaginatedData: null,

  isLoading: true,
  isCreating: false,
  isUpdating: false,

  isFullData: false,
  createdData: null,
  editStateId: null,
  updatedData: null,
  isDeleting: false,
  deletedData: null,

  isHasFilter: false,
  filterItems: [],
})

const getters = {
  statesList: state => state.states,
  statee: state => state.statee,
  statesPaginatedData: state => state.statesPaginatedData,

  isLoading: state => state.isLoading,
  isCreating: state => state.isCreating,
  isUpdating: state => state.isUpdating,

  isFullData: state => state.isFullData,

  createdData: state => state.createdData,
  editStateId: state => state.editStateId,
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
      await getStates(query)
      commit('setStates', states.value)
      commit('setStatesPaginatedData', statesPaginatedData.value)
      commit('setIsLoading', false)
      setQueryParamsToUrl(query)
      commit('setFilterItems', {
        pagination: query?.per_page,
        statee: query?.name,
        city: query?.city_name,
      })
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async fetchState({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await getState(id)
      commit('setStateDetail', statee.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async storeState({ commit }, state) {
    try {
      commit('setIsCreating', true)
      await storeState(state)
      commit('saveNewStates', state.value)
      commit('setIsCreating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async editState({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await editState(id)
      commit('setStateDetail', statee.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async updateState({ commit }, state) {
    try {
      commit('setIsUpdating', true)
      await updateState(state)
      commit('saveUpdatedState', state.value)
      commit('setIsUpdating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async deleteState({ commit }, id) {
    try {
      await destroyState(id)
      commit('setDeleteState', id)
    } catch (error) {
      displayError(error)
    }
  },

  async forceDeleteState({ commit }, id) {
    try {
      await forceDeleteState(id)
      commit('setDeleteState', id)
    } catch (error) {
      displayError(error)
    }
  },
  async restoreState({ commit }, id) {
    try {
      await restoreState(id)
    } catch (error) {
      displayError(error)
    }
  },
}

const mutations = {
  setStates: (state, states) => {
    state.states = states
  },

  setStatesPaginatedData: (state, statesPaginatedData) => {
    state.statesPaginatedData = statesPaginatedData
  },

  setStateDetail: (state, statee) => {
    state.statee = statee
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
  saveNewStates: (state, statee) => {
    state.states.unshift(statee)
    state.createdData = statee
  },
  saveUpdatedState: (state, statee) => {
    state.updatedData = statee
  },
  setDeleteState: (state, id) => {
    state.statesPaginatedData.data.filter(x => x.id !== id)
  },

  setHasFilter: (state, hasFilter) => {
    state.isHasFilter = hasFilter
  },

  setFilterItems: (state, { pagination, statee }) => {
    const filterItems = []

    if (state) {
      filterItems.push({
        name: 'state',
        filterData: state,
        clearFilter: 'name',
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
