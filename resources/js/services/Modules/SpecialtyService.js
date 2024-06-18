import useHandler from "@/services/handler"
import axios from "axios"
import { ref } from 'vue'
import { useToast } from "vue-toastification"
import "vue-toastification/dist/index.css"

const toast = useToast()

export default function useSpecialties() {
  const { displayError, generateUrl, setPagination } = useHandler()
  const specialties = ref([])
  let paginatedData = ref(null)
  const specialty = ref([])

  const getSpecialties = async query => {
    try {
      let response = await axios.get(generateUrl('/api/specialties', query))
      specialties.value = response.data.data
      paginatedData.value = setPagination(response)
    } catch (error) {
      displayError(error)
    }

  }

  const getSpecialty = async id => {
    let response = await axios.get('/api/specialties/' + id)
    specialty.value = response.data.data
  }

  const storeSpecialty = async data => {
    try {
      let response = await axios.post('/api/specialties', data)
      specialty.value = response.data.data
      toast.success("Specialty has been created successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const editSpecialty = async id => {
    let response = await axios.get('/api/specialties/' + id + '/edit')
    specialty.value = response.data.data
  }

  const updateSpecialty = async specialty => {
    try {
      let response = await axios.put('/api/specialties/' + specialty.id, specialty)
      specialty.value = response.data.data
      toast.success("Specialty has been updated successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const destroySpecialty = async id => {
    try {
      await axios.delete('/api/specialties/' + id)
    } catch (error) {
      displayError(error)
    }
  }

  const forceDeleteSpecialty = async id => {
    try {
      await axios.delete('/api/specialties/' + id + '/force-delete')
    } catch (error) {
      displayError(error)
    }
  }

  const restoreSpecialty = async id => {
    try {
      await axios.patch('/api/specialties/' + id + '/restore')
    } catch (error) {
      displayError(error)
    }
  }

  return {
    specialties,
    paginatedData,
    specialty,
    getSpecialties,
    getSpecialty,
    storeSpecialty,
    editSpecialty,
    updateSpecialty,
    destroySpecialty,
    forceDeleteSpecialty,
    restoreSpecialty,
  }
}
