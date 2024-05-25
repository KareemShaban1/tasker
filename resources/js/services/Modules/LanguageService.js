import useHandler from "@/services/handler"
import axios from "axios"
import { ref } from 'vue'
import { useToast } from "vue-toastification"

const toast = useToast()

export default function useLanguages() {
  const { displayError, generateUrl, setPagination } = useHandler()
  const languages = ref([])
  let languagesPaginatedData = ref(null)
  const language = ref([])

  const getLanguages = async query => {
    try {
      let response = await axios.get(generateUrl('/api/languages', query))
      languages.value = response.data.data
      languagesPaginatedData.value = setPagination(response)
    } catch (error) {
      displayError(error)
    }

  }

  const getLanguage = async id => {
    let response = await axios.get('/api/languages/' + id)
    language.value = response.data.data
  }

  const storeLanguage = async data => {
    try {
      let response = await axios.post('/api/languages', data)
      language.value = response.data.data
      toast.success("Language has been created successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const editLanguage = async id => {
    let response = await axios.get('/api/languages/' + id + '/edit')
    language.value = response.data.data
  }

  const updateLanguage = async language => {
    try {
      let response = await axios.put('/api/languages/' + language.id, language)
      language.value = response.data.data
      toast.success("Language has been updated successfully")
    } catch (error) {
      displayError(error)
    }
  }

  const destroyLanguage = async id => {
    try {
      await axios.delete('/api/languages/' + id)
    } catch (error) {
      displayError(error)
    }
  }

  const forceDeleteLanguage = async id => {
    try {
      await axios.delete('/api/languages/' + id + '/force-delete/')
    } catch (error) {
      displayError(error)
    }
  }

  const restoreLanguage = async id => {
    try {
      await axios.patch('/api/languages/' + id + '/restore')
    } catch (error) {
      displayError(error)
    }
  }

  return {
    languages,
    languagesPaginatedData,
    language,
    getLanguages,
    getLanguage,
    storeLanguage,
    editLanguage,
    updateLanguage,
    destroyLanguage,
    forceDeleteLanguage,
    restoreLanguage,
  }
}
