<template>
  <VDialog max-width="800">
    <VCard title="Create new taskType">
      <VCardText>
        <VRow>
          <VCol
            cols="12"
            md="6"
          >
            <VTextField
              v-model="form.type"
              label="Name"
              :error-messages="errors.type"
              @click:clear="errors.type = ''"
              @focus="errors.type = ''"
            />
          </VCol>
          <VCol cols="12">
            <VAutocomplete
              v-model="form.language_id"
              label="Language"
              :items="languages"
              item-title="name"
              item-value="id"
              clearable
              :error-messages="errors.language_id"
              @click:clear="errors.language_id = ''"
              @focus="errors.language_id = ''"
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
import useValidator from '@/pages/taskType/Validator'
import useLanguages from '@/services/Modules/LanguageService'
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'TaskTypeDialog',

  setup() {
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { languages, getLanguages } = useLanguages()
    const { errors, validate } = useValidator()

    const close = () => {
      store.commit('TaskType/setIsCreating', false)
    }

    const submit = () => {
      if (validate(form)) {
        store.dispatch('TaskType/storeTaskType', form.value).then(() => {
          store.dispatch('TaskType/fetchAllTaskTypes', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const form = ref({
      type: '',
      is_active: '',
      language_id: '',
    })

    const resetForm = () => {
      ;(form.value.type = ''), (form.value.is_active = ''), (form.value.language_id = '')
    }

    const updateIsActive = () => {
      if (!form.value.is_active) {
        form.value.is_active = 0
      }
    }

    onMounted(() => {
      getLanguages()
    })

    return {
      resetForm,
      form,
      close,
      submit,
      errors,
      languages,
      getLanguages,
      updateIsActive,
    }
  },
}
</script>
