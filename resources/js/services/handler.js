import { useToast } from 'vue-toastification'
import { ref } from "vue"

export default function useHandler() {
  const toast = useToast()

  const not_displayed_query_parameters = {
    'page': 1,
    'with_trashed': true,
    'per_page': 10,
    'paginate': true,
    'full_data': true,
  }

  function displayError(error) {
    console.log(error)
    if (error.response && error.response.status === 422) {
      const errors = error.response.data.errors
      for (let key in errors) {
        toast.warning(errors[key][0], { timeout: 2500 })
      }
    } else {
      console.log(error)
      toast.error('An error occurred, please contact admin.')
    }
  }

  function generateUrl(url, query) {
    let queryParams = []

    for (let key in query) {
      if (query[key] !== '' || query[key] !== null) {
        queryParams.push(`${key}=${query[key]}`)
      }
    }
    if (queryParams.length > 0) {
      url += '?' + queryParams.join('&')
    }

    return url
  }

  function getQueryParamsFromUrl() {
    const urlParams = new URLSearchParams(window.location.search)
    const query = reactive({})

    urlParams.forEach((value, key) => {
      query[key] = value
    })

    return query
  }

  function setQueryParamsToUrl(query) {
    if (query && typeof query === 'object') {
      let queryString = Object.keys(query)
        .map(key => `${key}=${query[key]}`)
        .join('&')
      let newUrl = window.location.pathname + '?' + queryString
      history.pushState({}, '', newUrl)
    }
  }

  function setPagination(response) {
    let pagination = { total: 0, per_page: 0, current_page: 0, total_pages: 0 }

    const paginatedData = ref({
      data: null,
      pagination: pagination,
    })

    if (response !== undefined && response.data !== undefined) {
      if (response.data.meta !== undefined && response.data.meta !== null) {
        pagination.total = response.data.meta.total || 0
        pagination.per_page = response.data.meta.per_page || 0
        pagination.current_page = response.data.meta.current_page || 0
        pagination.total_pages = response.data.meta.last_page || 0
      }

      paginatedData.value = {
        data: response.data.data,
        pagination: pagination,
      }
    }

    return paginatedData
  }

  function humanReadableDate(dateString) {
    let date = new Date(dateString)

    let dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
    let timeOptions = { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true }

    let formattedDate = date.toLocaleDateString(undefined, dateOptions)
    let formattedTime = date.toLocaleTimeString(undefined, timeOptions)

    return { date: formattedDate, time: formattedTime }
  }

  function convertToTitleCase(str) {
    let words = str.split(/[_\s]+/)

    return words.map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
  }

  function setFilterItems(query) {
    const not_displayed_query_parameters_keys = Object.keys(not_displayed_query_parameters)
    const filterItems = []

    for (const key in query) {
      if (query[key] && !not_displayed_query_parameters_keys.includes(key)) {
        filterItems.push({
          name: convertToTitleCase(key),
          filterData: query[key],
          clearFilter: key,
        })
      }
    }

    return filterItems
  }

  function clearFilterItems(query) {
    for (const key in query) {
      if (!(key in not_displayed_query_parameters)) {
        query[key] = ''
      } else {
        query[key] = not_displayed_query_parameters[key]
      }
    }
    return query
  }


  return {
    displayError,
    getQueryParamsFromUrl,
    setQueryParamsToUrl,
    generateUrl,
    setPagination,
    humanReadableDate,
    convertToTitleCase,
    setFilterItems,
    clearFilterItems,
  }
}
