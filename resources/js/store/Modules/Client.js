import useHandler from "@/services/handler"
import useClients from "@/services/Modules/ClientService"

const { displayError, setQueryParamsToUrl } = useHandler()

const {
  clients,
  client,
  paginatedData,
  getClients,
  getClient,
  storeClient,
  editClient,
  updateClient,
  destroyClient,
  forceDeleteClient,
  restoreClient,
} = useClients()

const state = () => ({
  clients: [],
  client: null,
  paginatedData: null,

  isLoading: true,
  isCreating: false,
  isUpdating: false,

  isFullData: false,
  createdData: null,
  editClientId: null,
  updatedData: null,
  isDeleting: false,
  deletedData: null,

  isHasFilter: false,
  filterItems: [],
})

const getters = {
  clientsList: state => state.clients,
  client: state => state.client,
  paginatedData: state => state.paginatedData,

  isLoading: state => state.isLoading,
  isCreating: state => state.isCreating,
  isUpdating: state => state.isUpdating,

  isFullData: state => state.isFullData,

  createdData: state => state.createdData,
  editClientId: state => state.editClientId,
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
      await getClients(query)
      commit('setClients', clients.value)
      commit('setClientsPaginatedData', paginatedData.value)
      commit('setIsLoading', false)
      setQueryParamsToUrl(query)
      commit('setFilterItems', { pagination: query?.per_page, client: query?.name_en, department: query?.department_name })
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async fetchClient({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await getClient(id)
      commit('setClientDetail', client.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async storeClient({ commit }, client) {
    try {
      commit('setIsCreating', true)
      await storeClient(client)
      commit('saveNewClients', client.value)
      commit('setIsCreating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async editClient({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await editClient(id)
      commit('setClientDetail', client.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async updateClient({ commit }, client) {
    try {
      commit('setIsUpdating', true)
      await updateClient(client)
      commit('saveUpdatedClient', client.value)
      commit('setIsUpdating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async deleteClient({ commit }, id) {
    try {
      await destroyClient(id)
      commit('setDeleteClient', id)
    } catch (error) {
      displayError(error)
    }
  },

  async forceDeleteClient({ commit }, id) {
    try {
      await forceDeleteClient(id)
      commit('setDeleteClient', id)
    } catch (error) {
      displayError(error)
    }
  },
  async restoreClient({ commit }, id) {
    try {
      await restoreClient(id)
    } catch (error) {
      displayError(error)
    }
  },

}

const mutations = {
  setClients: (state, clients) => {
    state.clients = clients
  },

  setClientsPaginatedData: (state, paginatedData) => {
    state.paginatedData = paginatedData
  },

  setClientDetail: (state, client) => {
    state.client = client
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
  saveNewClients: (state, client) => {
    state.clients.unshift(client)
    state.createdData = client
  },
  saveUpdatedClient: (state, client) => {
    state.updatedData = client
  },
  setDeleteClient: (state, id) => {
    state.paginatedData.data.filter(x => x.id !== id)
  },

  setHasFilter: (state, hasFilter) => {
    state.isHasFilter = hasFilter
  },

  setFilterItems: (state, { pagination, client, department }) => {
    const filterItems = []

    if (client) {
      filterItems.push({
        name: 'client',
        filterData: client,
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
