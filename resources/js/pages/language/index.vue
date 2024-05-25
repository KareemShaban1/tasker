<template>
  <LanguageIndex />

  <!-- Edit Dialog Part -->
  <EditLanguage
    v-if="isUpdating"
    v-model="isUpdating"
  />

  <!-- Create Dialog Part -->
  <CreateLanguage
    v-if="isCreating"
    v-model="isCreating"
  />
</template>

<script>
import LanguageIndex from "@/pages/language/components/LanguageIndex.vue"
import CreateLanguage from "@/pages/language/components/create/CreateLanguage.vue"
import EditLanguage from "@/pages/language/components/edit/EditLanguage.vue"

import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  components: { LanguageIndex, CreateLanguage, EditLanguage },

  setup() {
    const store = useStore()
    const isCreating = computed(() => store.getters['Language/isCreating'])
    const isUpdating = computed(() => store.getters['Language/isUpdating'])

    return {
      isCreating,
      isUpdating,
    }
  },
}
</script>
