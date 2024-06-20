import useHandler from "@/services/handler"
import axios from "axios"
import { ref } from 'vue'
import { useToast } from "vue-toastification"
import "vue-toastification/dist/index.css"

const toast = useToast()

export default function useUsers() {
  const { displayError, generateUrl, setPagination } = useHandler()
  const users = ref([])
  let paginatedData = ref(null)
  const user = ref([])

  const getUsers = async query => {
    try {
      let response = await axios.get(generateUrl('/api/users', query))
      users.value = response.data.data
      paginatedData.value = setPagination(response)
    } catch (error) {
      displayError(error)
    }

  }

  const getUser = async id => {
    let response = await axios.get('/api/users/' + id)
    user.value = response.data.data
  }

  const storeUser = async data => {
    try {
      let response = await axios.post('/api/users', data)
      user.value = response.data.data
      toast.success("User has been created successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const editUser = async id => {
    let response = await axios.get('/api/users/' + id + '/edit')
    user.value = response.data.data
  }

  const updateUser = async user => {
    try {
      let response = await axios.put('/api/users/' + user.id, user)
      user.value = response.data.data
      toast.success("User has been updated successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const destroyUser = async id => {
    try {
      await axios.delete('/api/users/' + id)
    } catch (error) {
      displayError(error)
    }
  }

  const forceDeleteUser = async id => {
    try {
      await axios.delete('/api/users/' + id + '/force-delete')
    } catch (error) {
      displayError(error)
    }
  }

  const restoreUser = async id => {
    try {
      await axios.patch('/api/users/' + id + '/restore')
    } catch (error) {
      displayError(error)
    }
  }

  return {
    users,
    paginatedData,
    user,
    getUsers,
    getUser,
    storeUser,
    editUser,
    updateUser,
    destroyUser,
    forceDeleteUser,
    restoreUser,
  }
}
