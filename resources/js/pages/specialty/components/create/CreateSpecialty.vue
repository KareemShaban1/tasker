<template>
  <VDialog max-width="800">
    <VCard title="Create new specialty">
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
// import { QuillEditor } from '@vueup/vue-quill'
// import '@vueup/vue-quill/dist/vue-quill.snow.css'
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'SpecialtyDialog',

  components: {
    // QuillEditor,
  },
  setup() {
    let description  =  reactive({})
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { errors, validate } = useValidator()

    const close = () => {
      store.commit('Specialty/setIsCreating', false)
    }

    const submit = () => {
      if (validate(form)) {
        store.dispatch('Specialty/storeSpecialty', form.value).then(() => {
          store.dispatch('Specialty/fetchAll', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const form = ref({
      name: '',
      description: '',
      is_active: '',
    })

    const resetForm = () => {
      form.value.name = ''
      form.value.is_active = ''
      form.value.description = ''
      // description.editor = ""
    }

    onMounted(() => {})

    return {
      resetForm,
      form,
      close,
      submit,
      errors,
      // description,
    }
  },
}
</script>
