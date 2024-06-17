<template>
  <VDialog max-width="800">
    <VCard title="Create new country">
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
          <VCol
            cols="12"
            md="6"
          >
            <VTextField
              v-model="form.specialties"
              label="Specialties"
              :error-messages="errors.specialties"
              @click:clear="errors.specialties = ''"
              @focus="errors.specialties = ''"
            />
          </VCol>
          <VCol
            cols="12"
            md="12"
          >
            <VTextField
              v-model="form.description"
              label="Description"
              :error-messages="errors.description"
              @click:clear="errors.description = ''"
              @focus="errors.description = ''"
            />
          </VCol>
          <VCol
            cols="12"
            md="12"
          >
            <VTextField
              v-model="form.location"
              label="Location"
              :error-messages="errors.location"
              @click:clear="errors.location = ''"
              @focus="errors.location = ''"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <VTextField
              v-model="form.email"
              label="Email"
              :error-messages="errors.email"
              @click:clear="errors.email = ''"
              @focus="errors.email = ''"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <VTextField
              v-model="form.phone"
              label="Phone"
              :error-messages="errors.phone"
              @click:clear="errors.phone = ''"
              @focus="errors.phone = ''"
            />
          </VCol>
          <VCol
            cols="12"
            md="4"
          >
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
          <VCol
            cols="12"
            md="4"
          >
            <VAutocomplete
              v-model="form.city_id"
              label="City"
              :items="cities"
              item-title="name"
              item-value="id"
              clearable
              :error-messages="errors.city_id"
              @click:clear="errors.city_id = ''"
              @focus="errors.city_id = ''"
            />
          </VCol>

          <VCol
            cols="12"
            md="4"
          >
            <VAutocomplete
              v-model="form.state_id"
              label="State"
              :items="states"
              item-title="name"
              item-value="id"
              clearable
              :error-messages="errors.state_id"
              @click:clear="errors.state_id = ''"
              @focus="errors.state_id = ''"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <VTextField
              v-model="form.source"
              label="Source"
              :error-messages="errors.source"
              @click:clear="errors.source = ''"
              @focus="errors.source = ''"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <div class="d-flex align-center gap-2">
              <VSwitch
                id="is_active"
                v-model="form.is_active"
                :value="1"
                :error-messages="errors.is_active"
                @click:clear="errors.is_active = ''"
                @focus="errors.is_active = ''"
                @change="updateIsActive"
              />
              <label
                class="text-capitalize"
                for="is_active"
              >Is Active</label>
            </div>
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
import useValidator from '@/pages/country/Validator'
import useCountries from '@/services/Modules/CountryService'
import useCities from '@/services/Modules/CityService'
import useStates from '@/services/Modules/StateService'
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'ClientDialog',

  setup() {
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { countries, getCountries } = useCountries()
    const { cities, getCities } = useCities()
    const { states, getStates } = useStates()
    const { errors, validate } = useValidator()

    const close = () => {
      store.commit('Client/setIsCreating', false)
    }

    const submit = () => {
      if (validate(form)) {
        store.dispatch('Client/storeClient', form.value).then(() => {
          store.dispatch('Client/fetchAll', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const form = ref({
      name: "",
      email: "",
      phone: "",
      country_id: "",
      city_id: "",
      state_id: "",
      source: "",
      is_active: "",
      description: "",
      location: "",
      specialties: "",
    })

    const resetForm = () => {
      form.value.name = "",
      form.value.email = "",
      form.value.phone = "",
      form.value.country_id = "",
      form.value.city_id = "",
      form.value.state_id = "",
      form.value.source = "",
      form.value.is_active = "",
      form.value.description = "",
      form.value.location = "",
      form.value.specialties = ""
    }

    onMounted(() => {
      getCountries()
      getCities()
      getStates()
    })

    return {
      resetForm,
      form,
      close,
      submit,
      errors,
      countries,
      cities,
      states,
    }
  },
}
</script>
