import useHandler from "@/services/handler"
import useLanguages from "@/services/Modules/LanguageService"

const { displayError, setQueryParamsToUrl } = useHandler()

const {
  languages,
  language,
  languagesPaginatedData,
  getLanguages,
  getLanguage,
  storeLanguage,
  editLanguage,
  updateLanguage,
  destroyLanguage,
  forceDeleteLanguage,
  restoreLanguage,
} = useLanguages()

const state = () => ({
  languages: [],
  language: null,
  languagesPaginatedData: null,

  isLoading: true,
  isCreating: false,
  isUpdating: false,

  isFullData: false,
  createdData: null,
  editLanguageId: null,
  updatedData: null,
  isDeleting: false,
  deletedData: null,

  isHasFilter: false,
  filterItems: [],
})

const getters = {
  languagesList: state => state.languages,
  language: state => state.language,
  languagesPaginatedData: state => state.languagesPaginatedData,

  isLoading: state => state.isLoading,
  isCreating: state => state.isCreating,
  isUpdating: state => state.isUpdating,

  isFullData: state => state.isFullData,

  createdData: state => state.createdData,
  editLanguageId: state => state.editLanguageId,
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
      await getLanguages(query)
      commit('setLanguages', languages.value)
      commit('setLanguagesPaginatedData', languagesPaginatedData.value)
      commit('setIsLoading', false)
      setQueryParamsToUrl(query)
      commit('setFilterItems', { pagination: query?.per_page, language: query?.name_en, department: query?.department_name })
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async fetchLanguage({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await getLanguage(id)
      commit('setLanguageDetail', language.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async storeLanguage({ commit }, language) {
    try {
      commit('setIsCreating', true)
      await storeLanguage(language)
      commit('saveNewLanguages', language.value)
      commit('setIsCreating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async editLanguage({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await editLanguage(id)
      commit('setLanguageDetail', language.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async updateLanguage({ commit }, language) {
    try {
      commit('setIsUpdating', true)
      await updateLanguage(language)
      commit('saveUpdatedLanguage', language.value)
      commit('setIsUpdating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async deleteLanguage({ commit }, id) {
    try {
      await destroyLanguage(id)
      commit('setDeleteLanguage', id)
    } catch (error) {
      displayError(error)
    }
  },

  async forceDeleteLanguage({ commit }, id) {
    try {
      await forceDeleteLanguage(id)
      commit('setDeleteLanguage', id)
    } catch (error) {
      displayError(error)
    }
  },
  async restoreLanguage({ commit }, id) {
    try {
      await restoreLanguage(id)
    } catch (error) {
      displayError(error)
    }
  },

}

const mutations = {
  setLanguages: (state, languages) => {
    state.languages = languages
  },

  setLanguagesPaginatedData: (state, languagesPaginatedData) => {
    state.languagesPaginatedData = languagesPaginatedData
  },

  setLanguageDetail: (state, language) => {
    state.language = language
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
  saveNewLanguages: (state, language) => {
    state.languages.unshift(language)
    state.createdData = language
  },
  saveUpdatedLanguage: (state, language) => {
    state.updatedData = language
  },
  setDeleteLanguage: (state, id) => {
    state.languagesPaginatedData.data.filter(x => x.id !== id)
  },

  setHasFilter: (state, hasFilter) => {
    state.isHasFilter = hasFilter
  },

  setFilterItems: (state, { pagination, language, department }) => {
    const filterItems = []

    if (language) {
      filterItems.push({
        name: 'language',
        filterData: language,
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
