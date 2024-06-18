import useHandler from "@/services/handler"
import axios from "axios"
import { ref } from 'vue'
import { useToast } from "vue-toastification"
import "vue-toastification/dist/index.css"

const toast = useToast()

export default function useCategories() {
  const { displayError, generateUrl, setPagination } = useHandler()
  const categories = ref([])
  let paginatedData = ref(null)
  const category = ref([])

  const getCategories = async query => {
    try {
      let response = await axios.get(generateUrl('/api/categories', query))
      categories.value = response.data.data
      paginatedData.value = setPagination(response)
    } catch (error) {
      displayError(error)
    }

  }

  const getCategory = async id => {
    let response = await axios.get('/api/categories/' + id)
    category.value = response.data.data
  }

  const storeCategory = async data => {
    try {
      let response = await axios.post('/api/categories', data)
      category.value = response.data.data
      toast.success("Category has been created successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const editCategory = async id => {
    let response = await axios.get('/api/categories/' + id + '/edit')
    category.value = response.data.data
  }

  const updateCategory = async category => {
    try {
      let response = await axios.put('/api/categories/' + category.id, category)
      category.value = response.data.data
      toast.success("Category has been updated successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const destroyCategory = async id => {
    try {
      await axios.delete('/api/categories/' + id)
    } catch (error) {
      displayError(error)
    }
  }

  const forceDeleteCategory = async id => {
    try {
      await axios.delete('/api/categories/' + id + '/force-delete')
    } catch (error) {
      displayError(error)
    }
  }

  const restoreCategory = async id => {
    try {
      await axios.patch('/api/categories/' + id + '/restore')
    } catch (error) {
      displayError(error)
    }
  }

  return {
    categories,
    paginatedData,
    category,
    getCategories,
    getCategory,
    storeCategory,
    editCategory,
    updateCategory,
    destroyCategory,
    forceDeleteCategory,
    restoreCategory,
  }
}
