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
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'CountryDialog',

  setup() {
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { errors, validate } = useValidator()

    const close = () => {
      store.commit('Country/setIsCreating', false)
    }

    const submit = () => {
      if (validate(form)) {
        store.dispatch('Country/storeCountry', form.value).then(() => {
          store.dispatch('Country/fetchAll', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const form = ref({
      name: '',
    })

    const resetForm = () => {
      form.value.name = ''
    }

    onMounted(() => {})

    return {
      resetForm,
      form,
      close,
      submit,
      errors,
    }
  },
}
</script>
