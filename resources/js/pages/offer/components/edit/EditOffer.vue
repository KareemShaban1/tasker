<template>
  <VDialog max-width="800">
    <VCard title="Edit offer">
      <VCardText>
        <VRow>
          <VCol
            cols="12"
            md="6"
          >
            <VTextField
              v-model="form.offer"
              label="Offer"
              :error-messages="errors.offer"
              @click:clear="errors.offer = ''"
              @focus="errors.offer = ''"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <VTextField
              v-model="form.offer_limit"
              label="Offer Limit"
              :error-messages="errors.offer_limit"
              @click:clear="errors.offer_limit = ''"
              @focus="errors.offer_limit = ''"
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
            md="6"
          >
            <VAutocomplete
              v-model="form.task_type_id"
              label="Task Type"
              :items="taskTypes"
              item-title="type"
              item-value="id"
              clearable
              :error-messages="errors.task_type_id"
              @click:clear="errors.task_type_id = ''"
              @focus="errors.task_type_id = ''"
            />
          </VCol>
         

          <VCol
            cols="12"
            md="6"
          >
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
import useValidator from '@/pages/offer/Validator'
import useTaskTypes from '@/services/Modules/TaskTypeService'
import useLanguages from '@/services/Modules/LanguageService'
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'OfferEdit',

  setup() {
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { taskTypes, getTaskTypes } = useTaskTypes()
    const { languages, getLanguages } = useLanguages()
    const { errors, validate } = useValidator()
    const offer = computed(() => store.getters['Offer/offer'])

    const form = ref({
      id: offer.value.id,
      offer: offer.value.offer,
      offer_limit: offer.value.offer_limit,
      description: offer.value.description,
      task_type_id: (offer.value.task_type?.id) || offer.value.task_type_id,
      language_id: (offer.value.language?.id) || offer.value.language_id,
      is_active: offer.value.is_active,
    })

    const submit = () => {
      if (validate(form)) {
        store.dispatch('Offer/updateOffer', form.value).then(() => {
          store.dispatch('Offer/fetchAll', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const close = () => {
      store.commit('Offer/setIsUpdating', false)
    }

    const resetForm = () => {
      form.value.offer = "",
      form.value.offer_limit = "",
      form.value.task_type_id = "",
      form.value.language_id = "",
      form.value.is_active = "",
      form.value.description = ""
    }

    onMounted(() => {
      getTaskTypes()
      getLanguages()
    })

    return {
      resetForm,
      form,
      close,
      submit,
      errors,
      taskTypes,
      languages,
    }
  },
}
</script>
