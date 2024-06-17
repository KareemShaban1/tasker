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
        <VRow>
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
                >Is Active</label
              >
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
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'LanguageDialog',

  setup() {
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { errors, validate } = useValidator()

    const close = () => {
      store.commit('Language/setIsCreating', false)
    }

    const submit = () => {
      if (validate(form)) {
        store.dispatch('Language/storeLanguage', form.value).then(() => {
          store.dispatch('Language/fetchAll', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const form = ref({
      name: '',
      is_active: '',
    })

    const resetForm = () => {
      ;(form.value.name = ''), (form.value.is_active = '')
    }

    const updateIsActive = () => {
      if (!form.value.is_active) {
        form.value.is_active = 0
      }
    }
    
    onMounted(() => {})

    return {
      resetForm,
      form,
      close,
      submit,
      errors,
      updateIsActive,
    }
  },
}
</script>
