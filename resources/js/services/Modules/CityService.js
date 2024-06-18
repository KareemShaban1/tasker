import useHandler from "@/services/handler"
import axios from "axios"
import { ref } from 'vue'
import { useToast } from "vue-toastification"
import "vue-toastification/dist/index.css"

const toast = useToast()

export default function useCities() {
  const { displayError, generateUrl, setPagination } = useHandler()
  const cities = ref([])
  let paginatedData = ref(null)
  const city = ref([])

  const getCities = async query => {
    try {
      let response = await axios.get(generateUrl('/api/cities', query))
      cities.value = response.data.data
      paginatedData.value = setPagination(response)
    } catch (error) {
      displayError(error)
    }

  }

  const getCity = async id => {
    let response = await axios.get('/api/cities/' + id)
    city.value = response.data.data
  }

  const storeCity = async data => {
    try {
      let response = await axios.post('/api/cities', data)
      city.value = response.data.data
      toast.success("City has been created successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const editCity = async id => {
    let response = await axios.get('/api/cities/' + id + '/edit')
    city.value = response.data.data
  }

  const updateCity = async city => {
    try {
      let response = await axios.put('/api/cities/' + city.id, city)
      city.value = response.data.data
      toast.success("City has been updated successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const destroyCity = async id => {
    try {
      await axios.delete('/api/cities/' + id)
    } catch (error) {
      displayError(error)
    }
  }

  const forceDeleteCity = async id => {
    try {
      await axios.delete('/api/cities/' + id + '/force-delete')
    } catch (error) {
      displayError(error)
    }
  }

  const restoreCity = async id => {
    try {
      await axios.patch('/api/cities/' + id + '/restore')
    } catch (error) {
      displayError(error)
    }
  }

  return {
    cities,
    paginatedData,
    city,
    getCities,
    getCity,
    storeCity,
    editCity,
    updateCity,
    destroyCity,
    forceDeleteCity,
    restoreCity,
  }
}
