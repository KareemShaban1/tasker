import useHandler from "@/services/handler"
import useSpecialties from "@/services/Modules/SpecialtyService"

const { displayError, setQueryParamsToUrl } = useHandler()

const {
  specialties,
  specialty,
  paginatedData,
  getSpecialties,
  getSpecialty,
  storeSpecialty,
  editSpecialty,
  updateSpecialty,
  destroySpecialty,
  forceDeleteSpecialty,
  restoreSpecialty,
} = useSpecialties()

const state = () => ({
  specialties: [],
  specialty: null,
  paginatedData: null,

  isLoading: true,
  isCreating: false,
  isUpdating: false,

  isFullData: false,
  createdData: null,
  editSpecialtyId: null,
  updatedData: null,
  isDeleting: false,
  deletedData: null,

  isHasFilter: false,
  filterItems: [],
})

const getters = {
  specialtiesList: state => state.specialties,
  specialty: state => state.specialty,
  paginatedData: state => state.paginatedData,

  isLoading: state => state.isLoading,
  isCreating: state => state.isCreating,
  isUpdating: state => state.isUpdating,

  isFullData: state => state.isFullData,

  createdData: state => state.createdData,
  editSpecialtyId: state => state.editSpecialtyId,
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
      await getSpecialties(query)
      commit('setSpecialties', specialties.value)
      commit('setSpecialtiesPaginatedData', paginatedData.value)
      commit('setIsLoading', false)
      setQueryParamsToUrl(query)
      commit('setFilterItems', { pagination: query?.per_page, specialty: query?.name_en, department: query?.department_name })
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async fetchSpecialty({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await getSpecialty(id)
      commit('setSpecialtyDetail', specialty.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async storeSpecialty({ commit }, specialty) {
    try {
      commit('setIsCreating', true)
      await storeSpecialty(specialty)
      commit('saveNewSpecialties', specialty.value)
      commit('setIsCreating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async editSpecialty({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await editSpecialty(id)
      commit('setSpecialtyDetail', specialty.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async updateSpecialty({ commit }, specialty) {
    try {
      commit('setIsUpdating', true)
      await updateSpecialty(specialty)
      commit('saveUpdatedSpecialty', specialty.value)
      commit('setIsUpdating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async deleteSpecialty({ commit }, id) {
    try {
      await destroySpecialty(id)
      commit('setDeleteSpecialty', id)
    } catch (error) {
      displayError(error)
    }
  },

  async forceDeleteSpecialty({ commit }, id) {
    try {
      await forceDeleteSpecialty(id)
      commit('setDeleteSpecialty', id)
    } catch (error) {
      displayError(error)
    }
  },
  async restoreSpecialty({ commit }, id) {
    try {
      await restoreSpecialty(id)
    } catch (error) {
      displayError(error)
    }
  },

}

const mutations = {
  setSpecialties: (state, specialties) => {
    state.specialties = specialties
  },

  setSpecialtiesPaginatedData: (state, paginatedData) => {
    state.paginatedData = paginatedData
  },

  setSpecialtyDetail: (state, specialty) => {
    state.specialty = specialty
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
  saveNewSpecialties: (state, specialty) => {
    state.specialties.unshift(specialty)
    state.createdData = specialty
  },
  saveUpdatedSpecialty: (state, specialty) => {
    state.updatedData = specialty
  },
  setDeleteSpecialty: (state, id) => {
    state.paginatedData.data.filter(x => x.id !== id)
  },

  setHasFilter: (state, hasFilter) => {
    state.isHasFilter = hasFilter
  },

  setFilterItems: (state, { pagination, specialty, department }) => {
    const filterItems = []

    if (specialty) {
      filterItems.push({
        name: 'specialty',
        filterData: specialty,
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
