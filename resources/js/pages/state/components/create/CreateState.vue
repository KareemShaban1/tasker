<template>
  <VDialog max-width="800">
    <VCard title="Create new state">
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
          <VCol cols="12">
            <VAutocomplete
              v-model="form.city_id"
              label="State"
              :items="cities"
              item-title="name"
              item-value="id"
              clearable
              :error-messages="errors.city_id"
              @click:clear="errors.city_id = ''"
              @focus="errors.city_id = ''"
            />
          </VCol>
        </VRow>
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
import useValidator from '@/pages/state/Validator'
import useCities from '@/services/Modules/CityService'
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'StateDialog',

  setup() {
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { cities, getCities } = useCities()
    const { errors, validate } = useValidator()

    const close = () => {
      store.commit('State/setIsCreating', false)
    }

    const submit = () => {
      if (validate(form)) {
        store.dispatch('State/storeState', form.value).then(() => {
          store.dispatch('State/fetchAllStates', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const form = ref({
      name: "",
      city_id: "",
    })

    const resetForm = () => {
      form.value.name = "",
      form.value.city_id = ""
    }

    onMounted(() => {
      getCities()
    })

    return {
      resetForm,
      form,
      close,
      submit,
      errors,
      cities,
      getCities,
    }
  },
}
</script>
