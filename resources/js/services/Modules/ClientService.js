import useHandler from "@/services/handler"
import axios from "axios"
import { ref } from 'vue'
import { useToast } from "vue-toastification"
import "vue-toastification/dist/index.css"


const toast = useToast()

export default function useClients() {
  const { displayError, generateUrl, setPagination } = useHandler()
  const clients = ref([])
  let paginatedData = ref(null)
  const client = ref([])

  const getClients = async query => {
    try {
      let response = await axios.get(generateUrl('/api/clients', query))
      clients.value = response.data.data
      paginatedData.value = setPagination(response)
    } catch (error) {
      displayError(error)
    }

  }

  const getClient = async id => {
    let response = await axios.get('/api/clients/' + id)
    client.value = response.data.data
  }

  const storeClient = async data => {
    try {
      let response = await axios.post('/api/clients', data)
      client.value = response.data.data
      toast.success("Client has been created successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const editClient = async id => {
    let response = await axios.get('/api/clients/' + id + '/edit')
    client.value = response.data.data
  }

  const updateClient = async client => {
    try {
      let response = await axios.put('/api/clients/' + client.id, client)
      client.value = response.data.data
      toast.success("Client has been updated successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const destroyClient = async id => {
    try {
      await axios.delete('/api/clients/' + id)
    } catch (error) {
      displayError(error)
    }
  }

  const forceDeleteClient = async id => {
    try {
      await axios.delete('/api/clients/' + id + '/force-delete')
    } catch (error) {
      displayError(error)
    }
  }

  const restoreClient = async id => {
    try {
      await axios.patch('/api/clients/' + id + '/restore')
    } catch (error) {
      displayError(error)
    }
  }

  return {
    clients,
    paginatedData,
    client,
    getClients,
    getClient,
    storeClient,
    editClient,
    updateClient,
    destroyClient,
    forceDeleteClient,
    restoreClient,
  }
}
