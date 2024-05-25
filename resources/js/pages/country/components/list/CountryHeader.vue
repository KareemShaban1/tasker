<template>
  <VCol
    lg="12"
    class="d-flex justify-space-between align-start align-md-center flex-column flex-md-row"
  >
    <h1 class="w-100 text-capitalize">Country</h1>
    <div class="FilterData w-100 justify-md-end justify-space-between flex-wrap d-flex align-start gap-2">
      <!--
        <VBtn
        class="text-capitalize"
        color="success"
        @click="importFromExcel"
        >
        Import From Excel
        <VIcon
        end
        icon="ri-upload-cloud-line"
        />
        </VBtn> 
      -->
      <VBtn
        class="text-capitalize"
        @click="createCountry"
      >
        Create Country
      </VBtn>

      <ShowResult :query="query" />
      <FilterCountry :query="query" />
    </div>
  </VCol>
</template>

<script>
import FilterCountry from '@/pages/country/components/list/FilterCountry.vue'
import ShowResult from '@/pages/country/components/list/ShowFilterResult.vue'
import { useStore } from 'vuex'

// import * as XLSX from 'xlsx'

export default {
  components: { FilterCountry, ShowResult },
  props: {
    query: {
      type: Object,
      required: true,
    },
  },

  setup() {
    const store = useStore()

    // const importFromExcel = () => {
    //   const input = document.createElement('input')

    //   input.type = 'file'
    //   input.accept = '.xlsx, .xls'
    //   input.onchange = e => {
    //     const file = e.target.files[0]
    //     if (!file) return

    //     const reader = new FileReader()

    //     reader.onload = event => {
    //       const data = new Uint8Array(event.target.result)
    //       const workbook = XLSX.read(data, { type: 'array' })

    //       const sheetName = workbook.SheetNames[0]
    //       const sheet = workbook.Sheets[sheetName]

    //       // Convert the sheet data to JSON format
    //       const jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 })
    //       const dataRows = jsonData.slice(1)

    //       console.log(dataRows)

    //       // Iterate over the data rows and call the storeCountry action for each Country
    //       dataRows.forEach(row => {
    //         const [name_ar, name_en, description_en, description_ar, is_active, department_id] = row

    //         store.dispatch("LaCountry/storeCountry", {
    //           name_ar,
    //           name_en,
    //           description_en,
    //           description_ar,
    //           is_active,
    //           department_id,
    //         }).then(() => {
    //           // Optionally, you can perform additional actions after storing each Country
    //           console.log(`Country ${name_en} stored successfully.`)
    //         })
    //       })

    //       // // After importing all Countries, fetch all Countries again to update the list
    //       store.dispatch("LaCountry/fetchAllCountries", { page: 1 })
    //     }
    //     reader.readAsArrayBuffer(file)
    //   }
    //   input.click()
    // }

    const createCountry = () => {
      store.commit('Country/setIsCreating', true)
    }

    return {
      createCountry,

      // importFromExcel,
    }
  },
}
</script>
