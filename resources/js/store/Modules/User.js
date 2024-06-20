import useHandler from "@/services/handler"
import useUsers from "@/services/Modules/UserService"

const { displayError, setQueryParamsToUrl } = useHandler()

const {
  users,
  user,
  paginatedData,
  getUsers,
  getUser,
  storeUser,
  editUser,
  updateUser,
  destroyUser,
  forceDeleteUser,
  restoreUser,
} = useUsers()

const state = () => ({
  users: [],
  user: null,
  paginatedData: null,

  isLoading: true,
  isCreating: false,
  isUpdating: false,

  isFullData: false,
  createdData: null,
  editUserId: null,
  updatedData: null,
  isDeleting: false,
  deletedData: null,

  isHasFilter: false,
  filterItems: [],
})

const getters = {
  usersList: state => state.users,
  user: state => state.user,
  paginatedData: state => state.paginatedData,

  isLoading: state => state.isLoading,
  isCreating: state => state.isCreating,
  isUpdating: state => state.isUpdating,

  isFullData: state => state.isFullData,

  createdData: state => state.createdData,
  editUserId: state => state.editUserId,
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
      await getUsers(query)
      commit('setUsers', users.value)
      commit('setUsersPaginatedData', paginatedData.value)
      commit('setIsLoading', false)
      setQueryParamsToUrl(query)
      commit('setFilterItems', { pagination: query?.per_page, user: query?.name_en, department: query?.department_name })
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async fetchUser({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await getUser(id)
      commit('setUserDetail', user.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async storeUser({ commit }, user) {
    try {
      commit('setIsCreating', true)
      await storeUser(user)
      commit('saveNewUsers', user.value)
      commit('setIsCreating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async editUser({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await editUser(id)
      commit('setUserDetail', user.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async updateUser({ commit }, user) {
    try {
      commit('setIsUpdating', true)
      await updateUser(user)
      commit('saveUpdatedUser', user.value)
      commit('setIsUpdating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async deleteUser({ commit }, id) {
    try {
      await destroyUser(id)
      commit('setDeleteUser', id)
    } catch (error) {
      displayError(error)
    }
  },

  async forceDeleteUser({ commit }, id) {
    try {
      await forceDeleteUser(id)
      commit('setDeleteUser', id)
    } catch (error) {
      displayError(error)
    }
  },
  async restoreUser({ commit }, id) {
    try {
      await restoreUser(id)
    } catch (error) {
      displayError(error)
    }
  },

}

const mutations = {
  setUsers: (state, users) => {
    state.users = users
  },

  setUsersPaginatedData: (state, paginatedData) => {
    state.paginatedData = paginatedData
  },

  setUserDetail: (state, user) => {
    state.user = user
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
  saveNewUsers: (state, user) => {
    state.users.unshift(user)
    state.createdData = user
  },
  saveUpdatedUser: (state, user) => {
    state.updatedData = user
  },
  setDeleteUser: (state, id) => {
    state.paginatedData.data.filter(x => x.id !== id)
  },

  setHasFilter: (state, hasFilter) => {
    state.isHasFilter = hasFilter
  },

  setFilterItems: (state, { pagination, user, department }) => {
    const filterItems = []

    if (user) {
      filterItems.push({
        name: 'user',
        filterData: user,
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
