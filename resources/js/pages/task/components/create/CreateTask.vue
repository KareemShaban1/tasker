<template>
  <VDialog max-width="800">
    <VCard title="Create new task">
      <VCardText>
        <VRow>
          <VCol
            cols="12"
            md="12"
          >
            <VTextField
              v-model="form.title"
              label="Title"
              :error-messages="errors.title"
              @click:clear="errors.title = ''"
              @focus="errors.title = ''"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <VTextField
              v-model="form.price"
              label="Price"
              :error-messages="errors.price"
              @click:clear="errors.price = ''"
              @focus="errors.price = ''"
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
            <VFileInput
              v-model="form.image"
              :rules="rulesImage"
              label="Image"
              accept="image/png, image/jpeg, image/bmp"
              placeholder="Pick an image"
              prepend-icon="mdi-camera-outline"
            />
          </VCol>
          <VCol
            cols="12"
            md="6"
          >
            <VFileInput
              v-model="form.video"
              :rules="rulesImage"
              label="Video"
              accept="video/mp4"
              placeholder="Pick an video"
              prepend-icon="mdi-video-outline"
            />
          </VCol>
          <VCol cols="12">
            <div
              id="description"
              class="editor-container"
            >
              <label for="description">Description</label>
              <QuillEditor
                v-model:content="description.editor"
                theme="snow"
                toolbar="essential"
                content-type="html"
              />
            </div>
          </VCol>
          <VCol cols="12" md="6">
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
          <VCol cols="12" md="6">
            <VAutocomplete
              v-model="form.client_id"
              label="Client"
              :items="clients"
              item-title="name"
              item-value="id"
              clearable
              :error-messages="errors.client_id"
              @click:clear="errors.client_id = ''"
              @focus="errors.client_id = ''"
            />
          </VCol>

          <VCol cols="12" md="4">
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

          <VCol cols="12" md="4">
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

          <VCol cols="12" md="4">
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
import useValidator from '@/pages/task/Validator'
import useLanguages from '@/services/Modules/LanguageService'
import useClients from '@/services/Modules/ClientService'
import useCountries from '@/services/Modules/CountryService'
import useCities from '@/services/Modules/CityService'
import useStates from '@/services/Modules/StateService'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'TaskDialog',

  components: {
    QuillEditor,
  },
  setup() {
    const description = reactive({ editor: '' })
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { languages, getLanguages } = useLanguages()
    const { clients, getClients } = useClients()
    const { countries, getCountries } = useCountries()
    const { cities, getCities } = useCities()
    const { states, getStates } = useStates()

    const { errors, validate } = useValidator()

    const close = () => {
      store.commit('Task/setIsCreating', false)
    }

    const submit = () => {
      if (validate(form)) {

        const formData = new FormData();

    // Append text fields
    formData.append('title', form.value.title);
    formData.append('source', form.value.source);
    formData.append('price', form.value.price);
    formData.append('location', form.value.location);
    formData.append('description', description.editor);
    formData.append('language_id', form.value.language_id);
    formData.append('client_id', form.value.client_id);
    formData.append('country_id', form.value.country_id);
    formData.append('city_id', form.value.city_id);
    formData.append('state_id', form.value.state_id);
    formData.append('is_active', form.value.is_active);

    // Append files (if selected)
    if (form.value.image) {
      formData.append('image', form.value.image[0]);
    }
    if (form.value.video) {
      formData.append('video', form.value.video[0]);
    }

    store.dispatch('Task/storeTask', formData).then(() => {
          store.dispatch('Task/fetchAll', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const form = ref({
      title: '',
      source: '',
      price: '',
      location: '',
      image: '',
      video: '',
      language_id: '',
      client_id: '',
      country_id: '',
      city_id: '',
      state_id: '',
      is_active: '',

    })

    const resetForm = () => {
      form.value.title = '',
      form.value.source = '',
      form.value.price = '',
      form.value.location = '',
      form.value.image = '',
      form.value.video = '',
      form.value.description = '',
      form.value.is_active = '',
      form.value.language_id = '',
      form.value.client_id = '',
      form.value.country_id = '',
      form.value.city_id = '',
      form.value.state_id = ''
    }

    const updateIsActive = () => {
      if (!form.value.is_active) {
        form.value.is_active = 0
      }
    }

    onMounted(() => {
      getLanguages()
      getClients()
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
      languages,
      clients,
      countries,
      cities,
      states,
      description,
      updateIsActive,
    }
  },
}
</script>
