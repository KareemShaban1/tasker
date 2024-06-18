import useHandler from "@/services/handler"
import axios from "axios"
import { ref } from 'vue'
import { useToast } from "vue-toastification"
import "vue-toastification/dist/index.css"


const toast = useToast()

export default function useCountries() {
  const { displayError, generateUrl, setPagination } = useHandler()
  const countries = ref([])
  let paginatedData = ref(null)
  const country = ref([])

  const getCountries = async query => {
    try {
      let response = await axios.get(generateUrl('/api/countries', query))
      countries.value = response.data.data
      paginatedData.value = setPagination(response)
    } catch (error) {
      displayError(error)
    }

  }

  const getCountry = async id => {
    let response = await axios.get('/api/countries/' + id)
    country.value = response.data.data
  }

  const storeCountry = async data => {
    try {
      let response = await axios.post('/api/countries', data)
      country.value = response.data.data
      toast.success("Country has been created successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const editCountry = async id => {
    let response = await axios.get('/api/countries/' + id + '/edit')
    country.value = response.data.data
  }

  const updateCountry = async country => {
    try {
      let response = await axios.put('/api/countries/' + country.id, country)
      country.value = response.data.data
      toast.success("Country has been updated successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const destroyCountry = async id => {
    try {
      await axios.delete('/api/countries/' + id)
    } catch (error) {
      displayError(error)
    }
  }

  const forceDeleteCountry = async id => {
    try {
      await axios.delete('/api/countries/' + id + '/force-delete')
    } catch (error) {
      displayError(error)
    }
  }

  const restoreCountry = async id => {
    try {
      await axios.patch('/api/countries/' + id + '/restore')
    } catch (error) {
      displayError(error)
    }
  }

  return {
    countries,
    paginatedData,
    country,
    getCountries,
    getCountry,
    storeCountry,
    editCountry,
    updateCountry,
    destroyCountry,
    forceDeleteCountry,
    restoreCountry,
  }
}
