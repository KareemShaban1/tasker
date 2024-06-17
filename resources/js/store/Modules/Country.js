import useHandler from "@/services/handler"
import useCountries from "@/services/Modules/CountryService"

const { displayError, setQueryParamsToUrl } = useHandler()

const {
  countries,
  country,
  countriesPaginatedData,
  getCountries,
  getCountry,
  storeCountry,
  editCountry,
  updateCountry,
  destroyCountry,
  forceDeleteCountry,
  restoreCountry,
} = useCountries()

const state = () => ({
  countries: [],
  country: null,
  countriesPaginatedData: null,

  isLoading: true,
  isCreating: false,
  isUpdating: false,

  isFullData: false,
  createdData: null,
  editCountryId: null,
  updatedData: null,
  isDeleting: false,
  deletedData: null,

  isHasFilter: false,
  filterItems: [],
})

const getters = {
  countriesList: state => state.countries,
  country: state => state.country,
  countriesPaginatedData: state => state.countriesPaginatedData,

  isLoading: state => state.isLoading,
  isCreating: state => state.isCreating,
  isUpdating: state => state.isUpdating,

  isFullData: state => state.isFullData,

  createdData: state => state.createdData,
  editCountryId: state => state.editCountryId,
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
      await getCountries(query)
      commit('setCountries', countries.value)
      commit('setCountriesPaginatedData', countriesPaginatedData.value)
      commit('setIsLoading', false)
      setQueryParamsToUrl(query)
      commit('setFilterItems', { pagination: query?.per_page, country: query?.name_en, department: query?.department_name })
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async fetchCountry({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await getCountry(id)
      commit('setCountryDetail', country.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async storeCountry({ commit }, country) {
    try {
      commit('setIsCreating', true)
      await storeCountry(country)
      commit('saveNewCountries', country.value)
      commit('setIsCreating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async editCountry({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await editCountry(id)
      commit('setCountryDetail', country.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async updateCountry({ commit }, country) {
    try {
      commit('setIsUpdating', true)
      await updateCountry(country)
      commit('saveUpdatedCountry', country.value)
      commit('setIsUpdating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async deleteCountry({ commit }, id) {
    try {
      await destroyCountry(id)
      commit('setDeleteCountry', id)
    } catch (error) {
      displayError(error)
    }
  },

  async forceDeleteCountry({ commit }, id) {
    try {
      await forceDeleteCountry(id)
      commit('setDeleteCountry', id)
    } catch (error) {
      displayError(error)
    }
  },
  async restoreCountry({ commit }, id) {
    try {
      await restoreCountry(id)
    } catch (error) {
      displayError(error)
    }
  },

}

const mutations = {
  setCountries: (state, countries) => {
    state.countries = countries
  },

  setCountriesPaginatedData: (state, countriesPaginatedData) => {
    state.countriesPaginatedData = countriesPaginatedData
  },

  setCountryDetail: (state, country) => {
    state.country = country
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
  saveNewCountries: (state, country) => {
    state.countries.unshift(country)
    state.createdData = country
  },
  saveUpdatedCountry: (state, country) => {
    state.updatedData = country
  },
  setDeleteCountry: (state, id) => {
    state.countriesPaginatedData.data.filter(x => x.id !== id)
  },

  setHasFilter: (state, hasFilter) => {
    state.isHasFilter = hasFilter
  },

  setFilterItems: (state, { pagination, country, department }) => {
    const filterItems = []

    if (country) {
      filterItems.push({
        name: 'country',
        filterData: country,
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
