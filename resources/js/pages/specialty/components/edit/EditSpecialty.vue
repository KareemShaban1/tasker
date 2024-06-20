<template>
  <VDialog max-width="800">
    <VCard title="Edit specialty">
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

          <!-- <VCol cols="12">
            <label for="">Description</label>
            <div :class="{ 'error-ql-container': messageBody }">
              <QuillEditor
                v-model:content="description.editor"
                theme="snow"
                toolbar="essential"
                content-type="html"
              />
            </div>
          </VCol> -->
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
import useValidator from '@/pages/specialty/Validator'
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'SpecialtyDialog',

  setup() {
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { errors, validate } = useValidator()
    const specialty = computed(() => store.getters['Specialty/specialty'])

    const form = ref({
      id: specialty.value.id,
      name: specialty.value.name,
      description: specialty.value.description,
      is_active: specialty.value.is_active,
    })

    const submit = () => {
      if (validate(form)) {
        store.dispatch('Specialty/updateSpecialty', form.value).then(() => {
          store.dispatch('Specialty/fetchAll', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const close = () => {
      store.commit('Specialty/setIsUpdating', false)
    }

    const resetForm = () => {
      form.value.name = ''
      form.value.description = ''
      form.value.is_active = ''
    }

    onMounted(() => {
      console.log(specialty)
    })

    return {
      resetForm,
      form,
      close,
      submit,
      errors,
      specialty,
    }
  },
}
</script>
