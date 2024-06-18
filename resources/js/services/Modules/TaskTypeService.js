import useHandler from "@/services/handler"
import axios from "axios"
import { ref } from 'vue'
import { useToast } from "vue-toastification"
import "vue-toastification/dist/index.css"

const toast = useToast()

export default function useTaskTypes() {
  const { displayError, generateUrl, setPagination } = useHandler()
  const taskTypes = ref([])
  let paginatedData = ref(null)
  const taskType = ref([])

  const getTaskTypes = async query => {
    try {
      let response = await axios.get(generateUrl('/api/taskTypes', query))
      taskTypes.value = response.data.data
      paginatedData.value = setPagination(response)
    } catch (error) {
      displayError(error)
    }

  }

  const getTaskType = async id => {
    let response = await axios.get('/api/taskTypes/' + id)
    taskType.value = response.data.data
  }

  const storeTaskType = async data => {
    try {
      let response = await axios.post('/api/taskTypes', data)
      taskType.value = response.data.data
      toast.success("TaskType has been created successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const editTaskType = async id => {
    let response = await axios.get('/api/taskTypes/' + id + '/edit')
    taskType.value = response.data.data
  }

  const updateTaskType = async taskType => {
    try {
      let response = await axios.put('/api/taskTypes/' + taskType.id, taskType)
      taskType.value = response.data.data
      toast.success("TaskType has been updated successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const destroyTaskType = async id => {
    try {
      await axios.delete('/api/taskTypes/' + id)
    } catch (error) {
      displayError(error)
    }
  }

  const forceDeleteTaskType = async id => {
    try {
      await axios.delete('/api/taskTypes/' + id + '/force-delete/')
    } catch (error) {
      displayError(error)
    }
  }

  const restoreTaskType = async id => {
    try {
      await axios.patch('/api/taskTypes/' + id + '/restore')
    } catch (error) {
      displayError(error)
    }
  }

  return {
    taskTypes,
    paginatedData,
    taskType,
    getTaskTypes,
    getTaskType,
    storeTaskType,
    editTaskType,
    updateTaskType,
    destroyTaskType,
    forceDeleteTaskType,
    restoreTaskType,
  }
}
