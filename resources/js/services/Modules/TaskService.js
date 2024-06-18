import useHandler from "@/services/handler"
import axios from "axios"
import { ref } from 'vue'
import { useToast } from "vue-toastification"
import "vue-toastification/dist/index.css"

const toast = useToast()

export default function useTasks() {
  const { displayError, generateUrl, setPagination } = useHandler()
  const tasks = ref([])
  let paginatedData = ref(null)
  const task = ref([])

  const getTasks = async query => {
    try {
      let response = await axios.get(generateUrl('/api/tasks', query))
      tasks.value = response.data.data
      paginatedData.value = setPagination(response)
    } catch (error) {
      displayError(error)
    }

  }

  const getTask = async id => {
    let response = await axios.get('/api/tasks/' + id)
    task.value = response.data.data
  }

  const storeTask = async data => {
    try {
      let response = await axios.post('/api/tasks', data)
      task.value = response.data.data
      toast.success("Task has been created successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const editTask = async id => {
    let response = await axios.get('/api/tasks/' + id + '/edit')
    task.value = response.data.data
  }

  const updateTask = async task => {
    try {
      const config = {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      }

      const response = await axios.post(`/api/tasks/${task.get('id')}`, task, config)
      // let response = await axios.put('/api/tasks/' + task.id, task)
      task.value = response.data.data
      toast.success("Task has been updated successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const destroyTask = async id => {
    try {
      await axios.delete('/api/tasks/' + id)
    } catch (error) {
      displayError(error)
    }
  }

  const forceDeleteTask = async id => {
    try {
      await axios.delete('/api/tasks/' + id + '/force-delete/')
    } catch (error) {
      displayError(error)
    }
  }

  const restoreTask = async id => {
    try {
      await axios.patch('/api/tasks/' + id + '/restore')
    } catch (error) {
      displayError(error)
    }
  }

  return {
    tasks,
    paginatedData,
    task,
    getTasks,
    getTask,
    storeTask,
    editTask,
    updateTask,
    destroyTask,
    forceDeleteTask,
    restoreTask,
  }
}
