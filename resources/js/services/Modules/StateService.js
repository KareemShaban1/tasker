import useHandler from '@/services/handler'
import axios from 'axios'
import { ref } from 'vue'
import { useToast } from 'vue-toastification'
import "vue-toastification/dist/index.css"

const toast = useToast()

export default function useStates() {
  const { displayError, generateUrl, setPagination } = useHandler()
  const states = ref([])
  let statesPaginatedData = ref(null)
  const statee = ref([])

  const getStates = async query => {
    try {
      let response = await axios.get(generateUrl('/api/states', query))
      states.value = response.data.data
      statesPaginatedData.value = setPagination(response)
    } catch (error) {
      displayError(error)
    }
  }

  const getState = async id => {
    let response = await axios.get('/api/states/' + id)
    statee.value = response.data.data
  }

  const storeState = async data => {
    try {
      let response = await axios.post('/api/states', data)
      statee.value = response.data.data
      toast.success('State has been created successfully')
    } catch (error) {
      displayError(error)
    }
  }

  const editState = async id => {
    let response = await axios.get('/api/states/' + id + '/edit')
    statee.value = response.data.data
  }

  const updateState = async state => {
    try {
      let response = await axios.put('/api/states/' + state.id, state)
      statee.value = response.data.data
      toast.success('State has been updated successfully')
    } catch (error) {
      displayError(error)
    }
  }

  const destroyState = async id => {
    try {
      await axios.delete('/api/states/' + id)
    } catch (error) {
      displayError(error)
    }
  }

  const forceDeleteState = async id => {
    try {
      await axios.delete('/api/states/' + id + '/force-delete/')
    } catch (error) {
      displayError(error)
    }
  }

  const restoreState = async id => {
    try {
      await axios.patch('/api/states/' + id + '/restore')
    } catch (error) {
      displayError(error)
    }
  }

  return {
    states,
    statesPaginatedData,
    statee,
    getStates,
    getState,
    storeState,
    editState,
    updateState,
    destroyState,
    forceDeleteState,
    restoreState,
  }
}
