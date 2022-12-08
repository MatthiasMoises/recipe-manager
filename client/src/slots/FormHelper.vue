<template>
  <v-container>
    <div id="form-header">
      <slot name="form-header"></slot>
    </div>
    <div id="form-fields">
      <slot name="form-fields"></slot>
    </div>
    <div id="form-controls">
      <slot name="form-controls"></slot>
    </div>
    <div id="form-process-elements">
      <slot name="form-process-elements"></slot>
    </div>
  </v-container>
</template>

<script>
export default {
  name: 'FormHelper'
}
</script>

<style scoped lang="scss">

#form-header {
  margin: 20px 0;
}

</style>
