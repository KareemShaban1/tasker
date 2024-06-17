<template>
  <VBtn
    size="small"
    density="default"
    class="app-filter-toggler rounded-s-xl rounded-0"
    color="black"
    :style="{zIndex:1001, backgroundColor: backgroundColor, color: textColor , marginInline:'0', minWidth: '38px',inlineSize:'30px'}"
    @click="handleClick"
  >
    <VIcon icon="ri-filter-line" />
  </VBtn>
</template>


<script>
export default {
  name: 'CustomButton',
  props: {
    backgroundColor: {
      type: String,
      default: 'black', // Default background color
    },
    textColor: {
      type: String,
      default: 'white', // Default text color
    },
  },
  methods: {
    handleClick() {
      // Emit an event to notify the parent component that the button has been clicked
      this.$emit('click')
    },
  },
}
</script>

<style scoped>
/* Add any custom styles here */
</style>
