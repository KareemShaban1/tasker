<template>
  <VDialog max-width="800">
    <VCard title="Edit city">
      <VCardText>
        <VRow>
          <VCol
            cols="12"
            md="6"
          >
            <VTextField
              v-model="form.name"
              label="Name"
              :error-messages="errors.name"
              @click:clear="errors.name = ''"
              @focus="errors.name = ''"
            />
          </VCol>
        </VRow>
        <VCol cols="12">
          <VAutocomplete
            v-model="form.country_id"
            label="Country"
            :items="countries"
            item-title="name"
            item-value="id"
            clearable
            :error-messages="errors.country_id"
            @click:clear="errors.country_id = ''"
            @focus="errors.country_id = ''"
          />
        </VCol>
      </VCardText>
      <VDivider />
      <div class="d-flex flex-wrap justify-space-between my-1 mx-4">
        <VBtn
          color="error"
          type="submit"
          class="text-capitalize"
          @click="close"
        >
          Close
        </VBtn>
        <VBtn
          type="submit"
          class="text-capitalize"
          @click="submit"
        >
          Submit
        </VBtn>
      </div>
    </VCard>
  </VDialog>
</template>

<script>
import { onMounted, ref } from 'vue'
import { useStore } from 'vuex'
import useHandler from '@/services/handler'
import useValidator from '@/pages/city/Validator'
import useCountries from '@/services/Modules/CountryService'
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'CityDialog',

  setup() {
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { countries, getCountries } = useCountries()
    const { errors, validate } = useValidator()
    const city = computed(() => store.getters['City/city'])

    const form = ref({
      id: city.value.id,
      name: city.value.name,
      country_id: city.value.country?.id || city.value.country_id,
    })

    const submit = () => {
      if (validate(form)) {
        store.dispatch('City/updateCity', form.value).then(() => {
          store.dispatch('City/fetchAll', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const close = () => {
      store.commit('City/setIsUpdating', false)
    }

    const resetForm = () => {
      ;(form.value.name = ''), (form.value.country_id = '')
    }

    onMounted(() => {
      getCountries()
      console.log(city)
    })

    return {
      resetForm,
      form,
      close,
      submit,
      errors,
      city,
      countries,
      getCountries,
    }
  },
}
</script>
