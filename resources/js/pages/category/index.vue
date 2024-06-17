<template>
  <CategoryIndex />

  <!-- Edit Dialog Part -->
  <EditCategory
    v-if="isUpdating"
    v-model="isUpdating"
  />

  <!-- Create Dialog Part -->
  <CreateCategory
    v-if="isCreating"
    v-model="isCreating"
  />
</template>

<script>
import CategoryIndex from '@/pages/category/components/CategoryIndex.vue'
import CreateCategory from '@/pages/category/components/create/CreateCategory.vue'
import EditCategory from '@/pages/category/components/edit/EditCategory.vue'

import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  components: { CategoryIndex, CreateCategory, EditCategory },

  setup() {
    const store = useStore()
    const isCreating = computed(() => store.getters['Category/isCreating'])
    const isUpdating = computed(() => store.getters['Category/isUpdating'])

    return {
      isCreating,
      isUpdating,
    }
  },
}
</script>
