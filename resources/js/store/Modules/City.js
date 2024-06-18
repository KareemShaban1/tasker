import useHandler from "@/services/handler"
import useCities from "@/services/Modules/CityService"

const { displayError, setQueryParamsToUrl } = useHandler()

const {
  cities,
  city,
  paginatedData,
  getCities,
  getCity,
  storeCity,
  editCity,
  updateCity,
  destroyCity,
  forceDeleteCity,
  restoreCity,
} = useCities()

const state = () => ({
  cities: [],
  city: null,
  paginatedData: null,

  isLoading: true,
  isCreating: false,
  isUpdating: false,

  isFullData: false,
  createdData: null,
  editCityId: null,
  updatedData: null,
  isDeleting: false,
  deletedData: null,

  isHasFilter: false,
  filterItems: [],
})

const getters = {
  citiesList: state => state.cities,
  city: state => state.city,
  paginatedData: state => state.paginatedData,

  isLoading: state => state.isLoading,
  isCreating: state => state.isCreating,
  isUpdating: state => state.isUpdating,

  isFullData: state => state.isFullData,

  createdData: state => state.createdData,
  editCityId: state => state.editCityId,
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
      await getCities(query)
      commit('setCities', cities.value)
      commit('setCitiesPaginatedData', paginatedData.value)
      commit('setIsLoading', false)
      setQueryParamsToUrl(query)
      commit('setFilterItems', { pagination: query?.per_page, city: query?.name_en, department: query?.department_name })
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async fetchCity({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await getCity(id)
      commit('setCityDetail', city.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async storeCity({ commit }, city) {
    try {
      commit('setIsCreating', true)
      await storeCity(city)
      commit('saveNewCities', city.value)
      commit('setIsCreating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async editCity({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await editCity(id)
      commit('setCityDetail', city.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async updateCity({ commit }, city) {
    try {
      commit('setIsUpdating', true)
      await updateCity(city)
      commit('saveUpdatedCity', city.value)
      commit('setIsUpdating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async deleteCity({ commit }, id) {
    try {
      await destroyCity(id)
      commit('setDeleteCity', id)
    } catch (error) {
      displayError(error)
    }
  },

  async forceDeleteCity({ commit }, id) {
    try {
      await forceDeleteCity(id)
      commit('setDeleteCity', id)
    } catch (error) {
      displayError(error)
    }
  },
  async restoreCity({ commit }, id) {
    try {
      await restoreCity(id)
    } catch (error) {
      displayError(error)
    }
  },

}

const mutations = {
  setCities: (state, cities) => {
    state.cities = cities
  },

  setCitiesPaginatedData: (state, paginatedData) => {
    state.paginatedData = paginatedData
  },

  setCityDetail: (state, city) => {
    state.city = city
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
  saveNewCities: (state, city) => {
    state.cities.unshift(city)
    state.createdData = city
  },
  saveUpdatedCity: (state, city) => {
    state.updatedData = city
  },
  setDeleteCity: (state, id) => {
    state.paginatedData.data.filter(x => x.id !== id)
  },

  setHasFilter: (state, hasFilter) => {
    state.isHasFilter = hasFilter
  },

  setFilterItems: (state, { pagination, city, department }) => {
    const filterItems = []

    if (city) {
      filterItems.push({
        name: 'city',
        filterData: city,
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
