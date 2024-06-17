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
          <VCol cols="12">
            <VAutocomplete
              v-model="form.parent_id"
              label="Category"
              :items="categories"
              item-title="name"
              item-value="id"
              clearable
              :error-messages="errors.parent_id"
              @click:clear="errors.parent_id = ''"
              @focus="errors.parent_id = ''"
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
          <VCol cols="12">
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
import useCategories from '@/services/Modules/CategoryService'
import useTaskTypes from '@/services/Modules/TaskTypeService'
import useLanguages from '@/services/Modules/LanguageService'
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'CategoryDialog',

  setup() {
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { categories, getCategories } = useCategories()
    const { taskTypes, getTaskTypes } = useTaskTypes()
    const { languages, getLanguages } = useLanguages()

    const { errors, validate } = useValidator()

    const close = () => {
      store.commit('Category/setIsCreating', false)
    }

    const submit = () => {
      if (validate(form)) {
        store.dispatch('Category/storeCategory', form.value).then(() => {
          store.dispatch('Category/fetchAll', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const form = ref({
      name: '',
      parent_id: '',
      language_id: '',
      task_type_id: '',
      is_active: '',
    })

    const resetForm = () => {
      ;(form.value.name = ''), (form.value.parent_id = '')
      form.value.language_id = ''
      form.value.task_type_id = ''
      form.value.is_active = ''
    }

    onMounted(() => {
      getCategories()
      getTaskTypes()
      getLanguages()
    })

    return {
      resetForm,
      form,
      close,
      submit,
      errors,
      categories,
      getCategories,
      taskTypes,
      getTaskTypes,
      languages,
      getLanguages,
    }
  },
}
</script>
