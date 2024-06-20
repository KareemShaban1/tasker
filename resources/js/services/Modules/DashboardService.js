import useHandler from "@/services/handler"
import axios from "axios"
import { ref } from 'vue'
import { useToast } from "vue-toastification"
import "vue-toastification/dist/index.css"

const toast = useToast()

export default function useDashboard() {
  const { displayError, generateUrl } = useHandler()
  const data = ref([])

  const getData = async query => {
    try {
      let response = await axios.get(generateUrl('/api/dashboard', query))
      data.value = response.data.data
    } catch (error) {
      displayError(error)
    }

  }

 

  return {
    data,
    getData
  }
}
