import useHandler from "@/services/handler"
import useOffers from "@/services/Modules/OfferService"

const { displayError, setQueryParamsToUrl } = useHandler()

const {
  offers,
  offer,
  offersPaginatedData,
  getOffers,
  getOffer,
  storeOffer,
  editOffer,
  updateOffer,
  destroyOffer,
  forceDeleteOffer,
  restoreOffer,
} = useOffers()

const state = () => ({
  offers: [],
  offer: null,
  offersPaginatedData: null,

  isLoading: true,
  isCreating: false,
  isUpdating: false,

  isFullData: false,
  createdData: null,
  editOfferId: null,
  updatedData: null,
  isDeleting: false,
  deletedData: null,

  isHasFilter: false,
  filterItems: [],
})

const getters = {
  offersList: state => state.offers,
  offer: state => state.offer,
  offersPaginatedData: state => state.offersPaginatedData,

  isLoading: state => state.isLoading,
  isCreating: state => state.isCreating,
  isUpdating: state => state.isUpdating,

  isFullData: state => state.isFullData,

  createdData: state => state.createdData,
  editOfferId: state => state.editOfferId,
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
      await getOffers(query)
      commit('setOffers', offers.value)
      commit('setOffersPaginatedData', offersPaginatedData.value)
      commit('setIsLoading', false)
      setQueryParamsToUrl(query)
      commit('setFilterItems', { pagination: query?.per_page, offer: query?.name_en, department: query?.department_name })
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async fetchOffer({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await getOffer(id)
      commit('setOfferDetail', offer.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async storeOffer({ commit }, offer) {
    try {
      commit('setIsCreating', true)
      await storeOffer(offer)
      commit('saveNewOffers', offer.value)
      commit('setIsCreating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async editOffer({ commit }, id) {
    try {
      commit('setIsLoading', true)
      await editOffer(id)
      commit('setOfferDetail', offer.value)
      commit('setIsLoading', false)
      commit('setIsUpdating', true)
    } catch (error) {
      displayError(error)
      commit('setIsLoading', false)
    }
  },

  async updateOffer({ commit }, offer) {
    try {
      commit('setIsUpdating', true)
      await updateOffer(offer)
      commit('saveUpdatedOffer', offer.value)
      commit('setIsUpdating', false)
    } catch (error) {
      displayError(error)
    }
  },

  async deleteOffer({ commit }, id) {
    try {
      await destroyOffer(id)
      commit('setDeleteOffer', id)
    } catch (error) {
      displayError(error)
    }
  },

  async forceDeleteOffer({ commit }, id) {
    try {
      await forceDeleteOffer(id)
      commit('setDeleteOffer', id)
    } catch (error) {
      displayError(error)
    }
  },
  async restoreOffer({ commit }, id) {
    try {
      await restoreOffer(id)
    } catch (error) {
      displayError(error)
    }
  },

}

const mutations = {
  setOffers: (state, offers) => {
    state.offers = offers
  },

  setOffersPaginatedData: (state, offersPaginatedData) => {
    state.offersPaginatedData = offersPaginatedData
  },

  setOfferDetail: (state, offer) => {
    state.offer = offer
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
  saveNewOffers: (state, offer) => {
    state.offers.unshift(offer)
    state.createdData = offer
  },
  saveUpdatedOffer: (state, offer) => {
    state.updatedData = offer
  },
  setDeleteOffer: (state, id) => {
    state.offersPaginatedData.data.filter(x => x.id !== id)
  },

  setHasFilter: (state, hasFilter) => {
    state.isHasFilter = hasFilter
  },

  setFilterItems: (state, { pagination, offer, department }) => {
    const filterItems = []

    if (offer) {
      filterItems.push({
        name: 'offer',
        filterData: offer,
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
