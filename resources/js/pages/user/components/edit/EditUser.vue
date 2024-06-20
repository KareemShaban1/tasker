<template>
  <VDialog max-width="800">
    <VCard title="Edit user">
      <VCardText>
        <VRow>
          <VCol
            cols="12"
            md="12"
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
            v-model="form.email"
            label="Email"
            :error-messages="errors.email"
            @click:clear="errors.email = ''"
            @focus="errors.email = ''"
          />
        </VCol>
         
        <VCol
        cols="12"
        md="12"
      >
        <VTextField
          v-model="form.password"
          label="Password"
          :error-messages="errors.password"
          @click:clear="errors.password = ''"
          @focus="errors.password = ''"
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
import useValidator from '@/pages/user/Validator'
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  name: 'EditUser',

  setup() {
    const store = useStore()
    const { getQueryParamsFromUrl } = useHandler()
    const { errors, validate } = useValidator()
    const user = computed(() => store.getters['User/user'])

    const form = ref({
      id: user.value.id,
      name: user.value.name,
      email: user.value.email,
    })

    const submit = () => {
      if (validate(form)) {
        store.dispatch('User/updateUser', form.value).then(() => {
          store.dispatch('User/fetchAll', getQueryParamsFromUrl())
          resetForm()
        })
      } else {
        toast.error('Please fill in all required fields.')
      }
    }

    const close = () => {
      store.commit('User/setIsUpdating', false)
    }

    const resetForm = () => {
      form.value.name = ''
      form.value.email = ''
      form.value.password = ''
    }

    onMounted(() => {

    })

    return {
      resetForm,
      form,
      close,
      submit,
      errors,
      user,
    }
  },
}
</script>
