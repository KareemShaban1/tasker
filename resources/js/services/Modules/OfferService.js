import useHandler from "@/services/handler"
import axios from "axios"
import { ref } from 'vue'
import { useToast } from "vue-toastification"
import "vue-toastification/dist/index.css"

const toast = useToast()

export default function useOffers() {
  const { displayError, generateUrl, setPagination } = useHandler()
  const offers = ref([])
  let paginatedData = ref(null)
  const offer = ref([])

  const getOffers = async query => {
    try {
      let response = await axios.get(generateUrl('/api/offers', query))
      offers.value = response.data.data
      paginatedData.value = setPagination(response)
    } catch (error) {
      displayError(error)
    }

  }

  const getOffer = async id => {
    let response = await axios.get('/api/offers/' + id)
    offer.value = response.data.data
  }

  const storeOffer = async data => {
    try {
      let response = await axios.post('/api/offers', data)
      offer.value = response.data.data
      toast.success("Offer has been created successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const editOffer = async id => {
    let response = await axios.get('/api/offers/' + id + '/edit')
    offer.value = response.data.data
  }

  const updateOffer = async offer => {
    try {
      let response = await axios.put('/api/offers/' + offer.id, offer)
      offer.value = response.data.data
      toast.success("Offer has been updated successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const destroyOffer = async id => {
    try {
      await axios.delete('/api/offers/' + id)
    } catch (error) {
      displayError(error)
    }
  }

  const forceDeleteOffer = async id => {
    try {
      await axios.delete('/api/offers/' + id + '/force-delete')
    } catch (error) {
      displayError(error)
    }
  }

  const restoreOffer = async id => {
    try {
      await axios.patch('/api/offers/' + id + '/restore')
    } catch (error) {
      displayError(error)
    }
  }

  return {
    offers,
    paginatedData,
    offer,
    getOffers,
    getOffer,
    storeOffer,
    editOffer,
    updateOffer,
    destroyOffer,
    forceDeleteOffer,
    restoreOffer,
  }
}
