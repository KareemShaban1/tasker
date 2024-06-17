<template>
  <VCardText class="mt-2">
    <VRow>
      <VCol cols="12">
        <VTextField 
          v-model="query.name"
          label="Name"
          clearable
          outlined
          @update:model-value="getResults"
        />
      </VCol>

      <VCol cols="12">
        <VTextField 
          v-model="query.country_name"
          label="Country Name"
          clearable
          outlined
          @update:model-value="getResults"
        />
      </VCol>
      <VCol cols="12">
        <VSelect
          v-model="query.per_page"
          label="Page Size"
          :items="[10, 20, 30, 40, 50]"
          @update:model-value="getResults"
        />
      </VCol>
    </VRow>
  </VCardText>
</template>

<script>
export default {
  name: "FilterProductLevel",
  components: {  },
  props: {
    query: {
      type: Object,
      required: true,
    },
    getResults: {
      type: Function,
      required: true,
    },
  },

  

  
}
</script>
