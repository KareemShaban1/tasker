import useHandler from "@/services/handler"
import useCategories from "@/services/Modules/CategoryService"

const { displayError, setQueryParamsToUrl } = useHandler()

const {
  categories,
  category,
  paginatedData,
  getCategories,
  getCategory,
  storeCategory,
  editCategory,
  updateCategory,
  destroyCategory,
  forceDeleteCategory,
  restoreCategory,
} = useCategories()

const state = () => ({
  categories: [],
  category: null,
  paginatedData: null,

  isLoading: true,
  isCreating: false,
  isUpdating: false,

  isFullData: false,
  createdData: null,
  editCategoryId: null,
  updatedData: null,
  isDeleting: false,
  deletedData: null,

  isHasFilter: false,
  filterItems: [],
})

const getters = {
  categoriesList: state => state.categories,
  category: state => state.category,
  paginatedData: state => state.paginatedData,

  isLoading: state => state.isLoading,
  isCreating: state => state.isCreating,
  isUpdating: state => state.isUpdating,

  isFullData: state => state.isFullData,

  createdData: state => state.createdData,
  editCategoryId: state => state.editCategoryId,
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
      await getCategories(query)
      commit('setCategories', categories.value)
      commit('setCategoriesPaginatedData', paginatedData.value)
      commit('setIsLoading', false)
      setQueryParamsToUrl(query)
      commit('setFilterItems', { pagination: query?.per_page, category: query?.name_en, department: query?.department_name })
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async fetchCategory({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await getCategory(id)
      commit('setCategoryDetail', category.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async storeCategory({ commit }, category) {
    try {
      commit('setIsCreating', true)
      await storeCategory(category)
      commit('saveNewCategories', category.value)
      commit('setIsCreating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async editCategory({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await editCategory(id)
      commit('setCategoryDetail', category.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async updateCategory({ commit }, category) {
    try {
      commit('setIsUpdating', true)
      await updateCategory(category)
      commit('saveUpdatedCategory', category.value)
      commit('setIsUpdating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async deleteCategory({ commit }, id) {
    try {
      await destroyCategory(id)
      commit('setDeleteCategory', id)
    } catch (error) {
      displayError(error)
    }
  },

  async forceDeleteCategory({ commit }, id) {
    try {
      await forceDeleteCategory(id)
      commit('setDeleteCategory', id)
    } catch (error) {
      displayError(error)
    }
  },
  async restoreCategory({ commit }, id) {
    try {
      await restoreCategory(id)
    } catch (error) {
      displayError(error)
    }
  },

}

const mutations = {
  setCategories: (state, categories) => {
    state.categories = categories
  },

  setCategoriesPaginatedData: (state, paginatedData) => {
    state.paginatedData = paginatedData
  },

  setCategoryDetail: (state, category) => {
    state.category = category
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
  saveNewCategories: (state, category) => {
    state.categories.unshift(category)
    state.createdData = category
  },
  saveUpdatedCategory: (state, category) => {
    state.updatedData = category
  },
  setDeleteCategory: (state, id) => {
    state.paginatedData.data.filter(x => x.id !== id)
  },

  setHasFilter: (state, hasFilter) => {
    state.isHasFilter = hasFilter
  },

  setFilterItems: (state, { pagination, category, department }) => {
    const filterItems = []

    if (category) {
      filterItems.push({
        name: 'category',
        filterData: category,
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
